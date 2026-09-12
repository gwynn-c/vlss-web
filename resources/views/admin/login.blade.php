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
        <form class="login-card" method="POST" action="{{ route('admin.login.attempt') }}">
            @csrf
            <div class="login-brand">
                <img src="{{ asset('img/logo-mark.png') }}" alt="" width="34" height="34">
                <span>VLSS Admin</span>
            </div>
            <h1>Welcome back</h1>
            <p class="sub">Sign in to manage the site.</p>

            @if ($errors->any())
                <div class="flash flash--error" role="alert">{{ $errors->first() }}</div>
            @endif

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <label class="checkline">
                <input type="checkbox" name="remember" value="1"> Keep me signed in
            </label>

            <div class="form__actions" style="margin-top:18px;">
                <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">Sign in</button>
            </div>
        </form>
    </div>
</body>
</html>
