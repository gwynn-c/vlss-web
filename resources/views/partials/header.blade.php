<header class="site-header">
    <a href="{{ route('home') }}" class="brand" aria-label="{{ config('site.name') }} — home">
        <img class="brand__mark" src="{{ asset('img/logo-mark.png') }}" alt="" width="40" height="40">
        <span class="brand__word">Very Long<br>Sword</span>
    </a>

    <nav class="nav" aria-label="Primary">
        <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Home</a>
        <a href="{{ route('games') }}" @class(['is-active' => request()->routeIs('games')])>Games</a>
        <a href="{{ route('services') }}" @class(['is-active' => request()->routeIs('services')])>Services</a>
        <a href="{{ route('studio') }}" @class(['is-active' => request()->routeIs('studio')])>Studio</a>
        <a href="{{ route('team') }}" @class(['is-active' => request()->routeIs('team')])>Team</a>
        <a href="{{ route('careers') }}" @class(['is-active' => request()->routeIs('careers')])>Careers</a>
        <a href="{{ route('contact') }}" class="btn btn-primary btn-sm nav-cta">Contact</a>
    </nav>

    <button class="nav-toggle" type="button" aria-label="Toggle menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>
</header>