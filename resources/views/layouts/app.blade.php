<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $pageTitle = trim($__env->yieldContent('title')) ?: config('site.name').' — '.config('site.tagline');
        $pageDescription = trim($__env->yieldContent('meta_description')) ?: config('site.description');
        $canonical = url()->current();
        $ogImage = asset('img/icon-512.png');
        $socialLinks = collect(config('site.socials', []))->filter(fn ($u) => $u && $u !== '#')->values();
        $structuredData = json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'Organization',
            'name'        => config('site.name'),
            'url'         => url('/'),
            'logo'        => $ogImage,
            'image'       => $ogImage,
            'description' => config('site.description'),
            'email'       => config('site.contact_email'),
            'sameAs'      => $socialLinks->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ $canonical }}">
    <meta name="theme-color" content="#0A0A0C">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:alt" content="{{ config('site.name') }} logo">
    <meta property="og:locale" content="en_US">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Structured data --}}
    <script type="application/ld+json">
{!! $structuredData !!}
    </script>

    {{-- Favicons --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">

    {{-- Fonts: Super Mabroz self-hosted (in app.css); Chivo from Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo:ital,wght@0,400;0,500;0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('fonts/SuperMabroz.woff2') }}" as="font" type="font/woff2" crossorigin>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('partials.header')

    <main id="top">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
