<?php

namespace App\Support;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenSSLAsymmetricKey;
use RuntimeException;

/**
 * End-to-end encryption for the admin login form.
 *
 * The browser encrypts the credentials with a fresh AES-256-GCM key, then wraps
 * that key with this server's RSA public key (RSA-OAEP). Only the holder of the
 * private key — stored on the `local` disk (storage/app/private, never
 * committed) and generated on first use — can read the submitted payload.
 *
 * Each rendered login form also carries a one-time nonce stored in the session;
 * it travels inside the encrypted payload so a captured request cannot be
 * replayed.
 *
 * OAEP uses SHA-1 (PHP's default for OPENSSL_PKCS1_OAEP_PADDING) because
 * selecting another digest needs PHP 8.5+, while the app supports ^8.3.
 * RSA-OAEP with SHA-1 is still a secure construction.
 */
class LoginEncryption
{
    public const KEY_PATH = 'admin-login-key.pem';

    public const NONCE_SESSION_KEY = 'admin_login_nonce';

    private const AES_KEY_BYTES = 32;

    private const GCM_IV_BYTES = 12;

    private const GCM_TAG_BYTES = 16;

    /**
     * The RSA public key as base64-encoded DER (SPKI), ready for Web Crypto's importKey('spki').
     */
    public function publicKey(): string
    {
        $pem = openssl_pkey_get_details($this->privateKey())['key'];

        return preg_replace('/-----[A-Z ]+-----|\s+/', '', $pem);
    }

    /**
     * Issue a fresh one-time nonce for a login form and remember it in the session.
     */
    public function issueNonce(Session $session): string
    {
        $nonce = Str::random(40);
        $session->put(self::NONCE_SESSION_KEY, $nonce);

        return $nonce;
    }

    /**
     * Decrypt a submitted payload. Returns the decoded fields, or null when the
     * payload is missing, malformed, tampered with, or encrypted for another key.
     *
     * @return array<string, mixed>|null
     */
    public function decrypt(mixed $encryptedKey, mixed $iv, mixed $payload): ?array
    {
        if (! is_string($encryptedKey) || ! is_string($iv) || ! is_string($payload)) {
            return null;
        }

        $encryptedKey = base64_decode($encryptedKey, true);
        $iv = base64_decode($iv, true);
        $payload = base64_decode($payload, true);

        if ($encryptedKey === false || $iv === false || $payload === false
            || strlen($iv) !== self::GCM_IV_BYTES
            || strlen($payload) <= self::GCM_TAG_BYTES) {
            return null;
        }

        if (! openssl_private_decrypt($encryptedKey, $aesKey, $this->privateKey(), OPENSSL_PKCS1_OAEP_PADDING)
            || strlen($aesKey) !== self::AES_KEY_BYTES) {
            return null;
        }

        // Web Crypto appends the GCM auth tag to the ciphertext.
        $ciphertext = substr($payload, 0, -self::GCM_TAG_BYTES);
        $tag = substr($payload, -self::GCM_TAG_BYTES);

        $plaintext = openssl_decrypt($ciphertext, 'aes-256-gcm', $aesKey, OPENSSL_RAW_DATA, $iv, $tag);

        if ($plaintext === false) {
            return null;
        }

        $fields = json_decode($plaintext, true);

        return is_array($fields) ? $fields : null;
    }

    private function privateKey(): OpenSSLAsymmetricKey
    {
        $disk = Storage::disk('local');

        if (! $disk->exists(self::KEY_PATH)) {
            Cache::lock('admin-login-key-generation', 10)->block(10, function () use ($disk): void {
                if (! $disk->exists(self::KEY_PATH)) {
                    $disk->put(self::KEY_PATH, $this->generatePrivateKeyPem());
                }
            });
        }

        $key = openssl_pkey_get_private($disk->get(self::KEY_PATH));

        if ($key === false) {
            throw new RuntimeException('The admin login key at storage/app/private/'.self::KEY_PATH.' is unreadable. Delete it to generate a new one.');
        }

        return $key;
    }

    private function generatePrivateKeyPem(): string
    {
        $options = ['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA];

        $key = openssl_pkey_new($options);
        $exported = $key !== false && openssl_pkey_export($key, $pem);

        // Some PHP builds (notably on Windows) ship without a default openssl.cnf,
        // which makes key generation fail. An empty config file is enough to proceed.
        if (! $exported) {
            $config = tempnam(sys_get_temp_dir(), 'openssl');
            $options['config'] = $config;

            try {
                $key = openssl_pkey_new($options);
                $exported = $key !== false && openssl_pkey_export($key, $pem, null, $options);
            } finally {
                @unlink($config);
            }
        }

        // Drain OpenSSL's error queue so stale errors don't leak into later calls.
        while (openssl_error_string() !== false) {
            //
        }

        if (! $exported) {
            throw new RuntimeException('Unable to generate the admin login RSA key with OpenSSL.');
        }

        return $pem;
    }
}
