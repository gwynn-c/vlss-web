<x-layout>
  <x-slot:title>
    About Us
  </x-slot:title>
  <div
  class="hero min-h-screen"
  style="background-image: url(https://img.daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.webp);"
>
  <div class="hero-overlay"></div>
  <div class="hero-content text-neutral-content text-center">
    <div class="max-w-md">
      <h1 class="mb-5 text-5xl font-bold">Hello there</h1>
      <p class="mb-5">
         Based in Lahore, Pakistan.
         Growing tired of all the mobile slop being created for money! We decided that if the world won't change, we'll have to change it. Our mission it to be that force that cause those around us to change. We are focused on creating fun, engaging and unique experiences. From RPGs to MMOs (A taboo I know), we are doing it all!
      </p>
      <button class="btn btn-primary">Work with Us!</button>
    </div>
  </div>
</div>

  <div class="py-24 sm:py-32">
    <div class="mx-auto grid max-w-7xl gap-20 px-6 lg:px-8 xl:grid-cols-3">
      <div class="max-w-xl">
        <h2 class="text-3xl font-semibold tracking-tight text-pretty text-white sm:text-4xl">Meet the Team!</h2>
        <p class="mt-6 text-lg/8">Meet the Team!</p>
      </div>
      <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">
        @foreach ($persons as $person)
          <li>
            <div class="flex items-center gap-x-6">
              <img src='' />
              <div>
                <h3 class="text-base/7 font-semibold tracking-tight text-white">{{ $person['name'] }}</h3>
               
                <p class="text-sm/6 font-semibold">{{ $person['title'] }}</p>
                <p class="text-sm/6">{{ $person['tagLine'] }}</p>

                <h3 class="font-semibold"> Favourite games!</h3>
                <p class="text-sm/10">{{ $person['favouriteGames'] }}</p>
                <a class="text-sm " href={{ $person['profileLink'] }}> View profile.</a>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

</x-layout>