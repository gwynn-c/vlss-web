<section class="hero" aria-labelledby="hero-title">
    <div class="hero__grid">
        <div class="hero__copy">
            <span class="eyebrow eyebrow--teal" data-reveal>{{ $hero['eyebrow'] }}</span>

            <h1 class="hero__title" id="hero-title" data-reveal>
                @foreach ($hero['title_lines'] as $line)
                    <span @class(['accent' => $line === ($hero['title_accent'] ?? null)])>{{ $line }}</span>@if(!$loop->last)<br>@endif
                @endforeach
            </h1>

            <p class="hero__lede" data-reveal>{{ $hero['body'] }}</p>

            <div class="hero__actions" data-reveal>
                <a href="#contact" class="btn btn-primary">Pitch us something</a>
                <a href="#games" class="btn btn-outline">See the work</a>
            </div>

            <div class="stats" data-reveal>
                @foreach ($hero['stats'] as $stat)
                    <div class="stat">
                        <span class="stat__value">{{ $stat['value'] }}</span>
                        <span class="stat__label">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hero__art" data-reveal>
            <div class="hero__glow" aria-hidden="true"></div>
            <img class="hero__mascot"
                 src="{{ asset('img/mascot-hero.png') }}"
                 alt="Very Longsword Studio mascot — an armored cat carrying a longsword"
                 width="470" height="493">
        </div>
    </div>
</section>
