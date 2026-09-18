<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    /**
     * Load the login page, then encrypt the fields the same way public/js/admin-login.js does:
     * AES-256-GCM over the JSON (tag appended), AES key wrapped with RSA-OAEP (SHA-1).
     *
     * @param  array<string, mixed>  $fields
     * @return array{encrypted_key: string, iv: string, payload: string}
     */
    protected function encryptedLogin(array $fields, ?string $nonce = null): array
    {
        $page = $this->get('/admin/login');
        $publicKey = "-----BEGIN PUBLIC KEY-----\n"
            .chunk_split($page->viewData('publicKey'), 64, "\n")
            ."-----END PUBLIC KEY-----\n";

        $fields['nonce'] = $nonce ?? $page->viewData('nonce');

        $aesKey = random_bytes(32);
        $iv = random_bytes(12);
        $ciphertext = openssl_encrypt(json_encode($fields), 'aes-256-gcm', $aesKey, OPENSSL_RAW_DATA, $iv, $tag);
        openssl_public_encrypt($aesKey, $wrappedKey, $publicKey, OPENSSL_PKCS1_OAEP_PADDING);

        return [
            'encrypted_key' => base64_encode($wrappedKey),
            'iv' => base64_encode($iv),
            'payload' => base64_encode($ciphertext.$tag),
        ];
    }

    public function test_login_page_renders_the_public_key_and_nonce_without_named_credential_fields(): void
    {
        $response = $this->get('/admin/login');

        $response->assertSee('data-public-key="'.$response->viewData('publicKey').'"', false);
        $response->assertSee('data-nonce="'.$response->viewData('nonce').'"', false);
        $response->assertDontSee('name="password"', false);
        $response->assertDontSee('name="email"', false);
    }

    public function test_encrypted_valid_credentials_log_the_admin_in(): void
    {
        $admin = User::factory()->create(['email' => 'admin@example.com']);
        $payload = $this->encryptedLogin(['email' => 'admin@example.com', 'password' => 'password', 'remember' => false]);

        $response = $this->post('/admin/login', $payload);

        $response->assertRedirect('/admin');
        $response->assertCookieMissing(Auth::guard()->getRecallerName());
        $this->assertAuthenticatedAs($admin);
    }

    public function test_remember_flag_inside_the_encrypted_payload_sets_the_remember_cookie(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);
        $payload = $this->encryptedLogin(['email' => 'admin@example.com', 'password' => 'password', 'remember' => true]);

        $response = $this->post('/admin/login', $payload);

        $response->assertCookie(Auth::guard()->getRecallerName());
    }

    public function test_plaintext_credentials_are_rejected(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);
        $this->get('/admin/login');

        $response = $this->post('/admin/login', ['email' => 'admin@example.com', 'password' => 'password']);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors(['email' => 'Your sign-in could not be verified. Please reload the page and try again.']);
        $this->assertGuest();
    }

    public function test_tampered_payload_is_rejected(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);
        $payload = $this->encryptedLogin(['email' => 'admin@example.com', 'password' => 'password']);
        $bytes = base64_decode($payload['payload']);
        $bytes[0] = chr(ord($bytes[0]) ^ 1);
        $payload['payload'] = base64_encode($bytes);

        $response = $this->post('/admin/login', $payload);

        $response->assertSessionHasErrors(['email' => 'Your sign-in could not be verified. Please reload the page and try again.']);
        $this->assertGuest();
    }

    public function test_payload_with_a_foreign_nonce_is_rejected(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);
        $payload = $this->encryptedLogin(['email' => 'admin@example.com', 'password' => 'password'], nonce: 'not-the-issued-nonce');

        $response = $this->post('/admin/login', $payload);

        $response->assertSessionHasErrors(['email' => 'Your sign-in could not be verified. Please reload the page and try again.']);
        $this->assertGuest();
    }

    public function test_replayed_payload_is_rejected_because_the_nonce_is_single_use(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);
        $payload = $this->encryptedLogin(['email' => 'admin@example.com', 'password' => 'wrong-password']);
        $this->post('/admin/login', $payload)
            ->assertSessionHasErrors(['email' => 'Those credentials do not match our records.']);

        $response = $this->post('/admin/login', $payload);

        $response->assertSessionHasErrors(['email' => 'Your sign-in could not be verified. Please reload the page and try again.']);
        $this->assertGuest();
    }

    public function test_wrong_password_is_rejected_and_the_email_is_kept(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);
        $payload = $this->encryptedLogin(['email' => 'admin@example.com', 'password' => 'wrong-password']);

        $response = $this->post('/admin/login', $payload);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors(['email' => 'Those credentials do not match our records.']);
        $response->assertSessionHasInput('email', 'admin@example.com');
        $this->assertGuest();
    }

    public function test_invalid_email_inside_the_payload_fails_validation(): void
    {
        $payload = $this->encryptedLogin(['email' => 'not-an-email', 'password' => 'password']);

        $response = $this->post('/admin/login', $payload);

        $response->assertSessionHasErrors(['email' => 'The email field must be a valid email address.']);
        $this->assertGuest();
    }

    public function test_extra_payload_keys_do_not_reach_the_user_lookup(): void
    {
        $admin = User::factory()->create(['email' => 'admin@example.com']);
        $payload = $this->encryptedLogin(['email' => 'admin@example.com', 'password' => 'password', 'id' => 999999]);

        $this->post('/admin/login', $payload);

        $this->assertAuthenticatedAs($admin);
    }
}
