<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in · {{ config('site.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="login-wrap">
        {{-- Inputs below have no name attributes: admin-login.js encrypts them into the hidden fields. --}}
        <form class="login-card" method="POST" action="{{ route('admin.login.attempt') }}"
              data-login-encrypt data-public-key="{{ $publicKey }}" data-nonce="{{ $nonce }}">
            @csrf
            <input type="hidden" name="encrypted_key" value="">
            <input type="hidden" name="iv" value="">
            <input type="hidden" name="payload" value="">
            <div class="login-brand">
                <img src="{{ asset('img/logo-mark.png') }}" alt="" width="34" height="34">
                <span>VLSS Admin</span>
            </div>
            <h1>Welcome back</h1>
            <p class="sub">Sign in to manage the site.</p>

            @if ($errors->any())
                <div class="flash flash--error" role="alert">{{ $errors->first() }}</div>
            @endif

            <div class="flash flash--error" role="alert" data-login-error hidden></div>

            <noscript>
                <div class="flash flash--error">JavaScript is required to sign in: your credentials are encrypted in the browser before they are sent.</div>
            </noscript>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" autocomplete="current-password" required>
            </div>

            <label class="checkline">
                <input id="remember" type="checkbox" value="1"> Keep me signed in
            </label>

            <div class="form__actions" style="margin-top:18px;">
                <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">Sign in</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/admin-login.js') }}" defer></script>
</body>
</html>
