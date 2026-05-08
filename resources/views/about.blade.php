<x-layout>
<x-slot:title>
    About Us
</x-slot:title>
<div class="hero  min-h-screen">
  <div class="hero-content text-justify">
    <div class="max-w-md">
      <h1 class="text-5xl font-bold">Our Mission!</h1>
      <p class="py-6">
        Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
        quasi. In deleniti eaque aut repudiandae et a id nisi.
      </p>
      <button class="btn btn-primary">Work with Us</button>
    </div>
  </div>
</div>

<div class="py-24 sm:py-32">
  <div class="mx-auto grid max-w-7xl gap-20 px-6 lg:px-8 xl:grid-cols-3">
    <div class="max-w-xl">
      <h2 class="text-3xl font-semibold tracking-tight text-pretty text-white sm:text-4xl">Meet the Team</h2>
      <p class="mt-6 text-lg/8">More bullshiting about how we are so lovely</p>
    </div>
    <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">
        @foreach ($persons as $person)
            <li>
        <div class="flex items-center gap-x-6">
          <img src=''/>
          <div>
            <h3 class="text-base/7 font-semibold tracking-tight text-white">{{ $person['name'] }}</h3>
            <p class="text-sm/6 font-semibold">{{ $person['title'] }}</p>
            <p class="text-sm/6 font-semibold">{{ $person['tagLine'] }}</p>

          </div>
        </div>
      </li>
        @endforeach
     
    </ul>
  </div>
</div>

</x-layout>