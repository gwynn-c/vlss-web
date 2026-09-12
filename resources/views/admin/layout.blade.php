<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') · {{ config('site.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin">
        <aside class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar__brand">
                <img src="{{ asset('img/logo-mark.png') }}" alt="" width="34" height="34">
                <span>VLSS<br><small>Content admin</small></span>
            </a>

            <nav class="sidebar__nav">
                <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
                <a href="{{ route('admin.hero.edit') }}" @class(['active' => request()->routeIs('admin.hero.*')])>Hero</a>

                @foreach (config('admin.sections') as $key => $section)
                    <a href="{{ route('admin.sections.index', $key) }}"
                       @class(['active' => request()->routeIs('admin.sections.*') && request()->route('section') === $key])>
                        <span class="ic">{{ $section['icon'] ?? '•' }}</span> {{ $section['label'] }}
                    </a>
                @endforeach

                <a href="{{ route('admin.settings.edit') }}" @class(['active' => request()->routeIs('admin.settings.*')])>Site settings</a>
            </nav>

            <div class="sidebar__foot">
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="ghost">View site ↗</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="ghost">Log out</button>
                </form>
            </div>
        </aside>

        <main class="content">
            @if (session('status'))
                <div class="flash" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash flash--error" role="alert">
                    Please fix the errors below.
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
