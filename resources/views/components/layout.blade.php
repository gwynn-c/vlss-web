<!DOCTYPE html>
<html lang="en" data-theme="black">

<head>
  <meta charset="UTF-8">
  <meta name-="viewport" content="width=device-width, intial-scale=1.0">
  <title>{{ isset($title) ? $title . ' - VLSS' : 'VLSS' }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />


  @vite(['resources/css/app.css', 'resource/js/app.js'])
</head>

<body class="min-h-screen flex flex-col font-sans bg-base-100">
  <nav class="navbar bg-base-100">
    <div class="navbar-start p-20">
      <a href="/" class="btn btn-ghost btn-sm">Welcome!</a>
      <a href="/games?" class="btn btn-ghost btn-sm">Games</a>
      <a href="/about-us?" class="btn btn-ghost btn-sm">About Us</a>

    </div>
    <div class="navbar-center">
      <img src="banner.png" class="" width="400" draggable="false" />
    </div>
    <div class="navbar-end p-20">
      <a href="/privacy-policy?" class="btn btn-ghost btn-sm">Privacy Policy</a>
      <a href="/careers" class="btn btn-ghost btn-sm">Careers</a>
    </div>
  </nav>
  <main class="flex-1 container mx-auto px-4 py-8">
    {{ $slot }}
  </main>

  <footer class="footer sm:footer-horizontal bg-base-100 text-base-content p-10">
    <aside>
      <img fill-rule="evenodd" clip-rule="evenodd" width="50" height="50" viewBox="0 0 24 24" class=""
        src="VLSS ICON.jpg">
      </img>
      <p>
        Very Longsword Studio
        <br />
        We make games!
      </p>
    </aside>
    <nav>
      <h6 class="footer-title">Services</h6>
      <a class="link link-hover">Game Design</a>
      <a class="link link-hover">Graphic Design</a>
      <a class="link link-hover">Game Development</a>
    </nav>
    <nav>
      <h6 class="footer-title">Company</h6>
      <a class="link link-hover" href="/about-us">About us</a>
      <a class="link link-hover" href="#">Contact</a>
      <a class="link link-hover" href="#">Jobs</a>
    </nav>
    <nav>
      <h6 class="footer-title">Legal</h6>
      <a class="link link-hover">Terms of use</a>
      <a class="link link-hover" href="/privacy-policy">Privacy policy</a>
      <a class="link link-hover" href="#">Cookie policy</a>
    </nav>
  </footer>

</html>