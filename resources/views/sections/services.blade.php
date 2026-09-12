<section class="section section--alt" id="services" aria-labelledby="services-title">
    <div class="container services__grid">
        <div class="services__intro" data-reveal>
            <span class="eyebrow eyebrow--purple no-rule">02 — Services</span>
            <h2 class="section-title" id="services-title">What you can<br>hand us</h2>
            <p class="services__lead">Got something half-formed? Bring it. We'll help you find the edge.</p>
            <a href="#contact" class="btn btn-cream" style="align-self:flex-start;margin-top:6px;">Start a project</a>
        </div>

        <div class="services__list">
            @foreach ($services as $service)
                <div class="service-row" data-reveal>
                    <span class="service-row__num">{{ $service['num'] }}</span>
                    <div>
                        <h3 class="service-row__title">{{ $service['title'] }}</h3>
                        <p class="service-row__body">{{ $service['body'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
