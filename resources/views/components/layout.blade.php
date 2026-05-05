<!DOCTYPE html>
<html lang="en" data-theme="black">
<head>
    <meta charset="UTF-8">
    <meta name-="viewport" content="width=device-width, intial-scale=1.0">
    <title>{{ isset($title)?$title.' - VLSS' : 'VLSS' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />


    @vite(['resources/css/app.css', 'resource/js/app.js'])
</head>
<body class="min-h-screen flex flex-col font-sans bg-base-100">
    <nav class="navbar bg-base-100">
    <div class="navbar-start avatar w-24 rounded">
         <img src="VLSS ICON.jpg" alt="VLSS Logo">
    </div>
    <div class="navbar-start">
        <a href="#" class="btn btn-ghost btn-sm">Welcome!</a>
        <a href="#" class="btn btn-ghost btn-sm">Games</a>
        <a href="#" class="btn btn-ghost btn-sm">About Us</a>

    </div>
    <div class="navbar-end">
        <a href="#" class="btn btn-ghost btn-sm">Privacy Policy</a>
        <a href="#" class="btn btn-ghost btn-sm">Careers</a>
        <input type="checkbox" value="light" class="toggle theme-controller" />

    </div>
    </nav>
    <main class="flex-1 container mx-auto px-4 py-8">
    {{ $slot }}
    </main>
</html>