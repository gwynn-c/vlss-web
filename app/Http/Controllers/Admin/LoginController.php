<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\LoginEncryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function show(Request $request, LoginEncryption $encryption)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login', [
            'publicKey' => $encryption->publicKey(),
            'nonce' => $encryption->issueNonce($request->session()),
        ]);
    }

    /**
     * Credentials arrive encrypted (see public/js/admin-login.js); plaintext
     * email/password fields are never accepted.
     */
    public function login(Request $request, LoginEncryption $encryption)
    {
        // Single use: pulled before anything else so a failed or replayed attempt can't reuse it.
        $expectedNonce = $request->session()->pull(LoginEncryption::NONCE_SESSION_KEY);

        $fields = $encryption->decrypt(
            $request->input('encrypted_key'),
            $request->input('iv'),
            $request->input('payload'),
        );

        if ($fields === null
            || ! is_string($expectedNonce)
            || ! is_string($fields['nonce'] ?? null)
            || ! hash_equals($expectedNonce, $fields['nonce'])) {
            return back()->withErrors([
                'email' => 'Your sign-in could not be verified. Please reload the page and try again.',
            ]);
        }

        $validator = Validator::make($fields, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = is_string($fields['email'] ?? null) ? $fields['email'] : '';

        if ($validator->fails()) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors($validator);
        }

        // Only email + password: every other key would become a where clause in the user lookup.
        $credentials = $validator->safe()->only(['email', 'password']);
        $remember = filter_var($fields['remember'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors(['email' => 'Those credentials do not match our records.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
