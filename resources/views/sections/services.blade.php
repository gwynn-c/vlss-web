<section class="section section--alt" aria-labelledby="services-title">
    <div class="container">
        <div class="services__list">
            @foreach ($services as $service)
                <div class="service-row" data-reveal>
                    <span class="service-row__num">{{ $service['num'] }}</span>
                    <div>
                        <h2 class="service-row__title">{{ $service['title'] }}</h2>
                        <p class="service-row__body">{{ $service['body'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="services__foot" data-reveal>
            <a href="{{ route('contact') }}" class="btn btn-primary">Start a project</a>
        </div>
    </div>
</section>