/* Very Longsword Studio — admin login payload encryption (no build step, vanilla JS)
 *
 * Credentials never leave the browser in plaintext. On submit we:
 *   1. generate a one-off AES-256-GCM key and encrypt {email, password, remember, nonce} with it;
 *   2. wrap that AES key with the server's RSA public key (RSA-OAEP, SHA-1 — see App\Support\LoginEncryption);
 *   3. post only the three base64 blobs (encrypted_key, iv, payload) plus the CSRF token.
 *
 * Web Crypto requires a secure context: HTTPS, or http://localhost / 127.0.0.1.
 */
(function (root) {
  'use strict';

  function bytesToBase64(buffer) {
    var bytes = new Uint8Array(buffer);
    var binary = '';
    for (var i = 0; i < bytes.length; i++) {
      binary += String.fromCharCode(bytes[i]);
    }
    return root.btoa(binary);
  }

  function base64ToBytes(base64) {
    var binary = root.atob(base64);
    var bytes = new Uint8Array(binary.length);
    for (var i = 0; i < binary.length; i++) {
      bytes[i] = binary.charCodeAt(i);
    }
    return bytes;
  }

  function isSupported() {
    return !!(root.crypto && root.crypto.subtle && root.TextEncoder);
  }

  async function encrypt(publicKeyBase64, fields) {
    var subtle = root.crypto.subtle;

    var rsaKey = await subtle.importKey(
      'spki', base64ToBytes(publicKeyBase64), { name: 'RSA-OAEP', hash: 'SHA-1' }, false, ['encrypt']
    );
    var aesKey = await subtle.generateKey({ name: 'AES-GCM', length: 256 }, true, ['encrypt']);
    var iv = root.crypto.getRandomValues(new Uint8Array(12));

    var plaintext = new root.TextEncoder().encode(JSON.stringify(fields));
    var ciphertext = await subtle.encrypt({ name: 'AES-GCM', iv: iv }, aesKey, plaintext);
    var wrappedKey = await subtle.encrypt({ name: 'RSA-OAEP' }, rsaKey, await subtle.exportKey('raw', aesKey));

    return {
      encrypted_key: bytesToBase64(wrappedKey),
      iv: bytesToBase64(iv),
      payload: bytesToBase64(ciphertext),
    };
  }

  root.VlssLoginEncryption = { encrypt: encrypt, isSupported: isSupported };

  /* --- wire up the login form --------------------------------------------- */
  if (!root.document) return;

  var form = root.document.querySelector('[data-login-encrypt]');
  if (!form) return;

  var errorBox = form.querySelector('[data-login-error]');
  var submitButton = form.querySelector('button[type="submit"]');
  var busy = false;

  function showError(message) {
    errorBox.textContent = message;
    errorBox.hidden = false;
  }

  if (!isSupported()) {
    showError('Secure sign-in needs a secure connection (HTTPS). Please open this page over https://.');
    submitButton.disabled = true;
    return;
  }

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (busy) return;
    busy = true;
    submitButton.disabled = true;

    var password = form.querySelector('#password');

    encrypt(form.dataset.publicKey, {
      email: form.querySelector('#email').value,
      password: password.value,
      remember: form.querySelector('#remember').checked,
      nonce: form.dataset.nonce,
    }).then(function (encrypted) {
      form.elements.encrypted_key.value = encrypted.encrypted_key;
      form.elements.iv.value = encrypted.iv;
      form.elements.payload.value = encrypted.payload;
      password.value = '';
      form.submit(); // native submit: does not re-trigger this handler
    }).catch(function () {
      busy = false;
      submitButton.disabled = false;
      showError('Could not encrypt your sign-in. Please reload the page and try again.');
    });
  });
})(typeof window !== 'undefined' ? window : globalThis);
