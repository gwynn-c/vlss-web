<section class="section" aria-labelledby="games-title">
    <div class="container">
        <div class="games__grid">
            @foreach ($games as $game)
                <article class="game-card" data-reveal>
                    <div class="game-card__media">
                        @if (!empty($game['image']))
                            <img src="{{ asset($game['image']) }}" alt="{{ $game['title'] }} key art">
                        @else
                            <span class="img-slot">{{ $game['image_hint'] ?? 'Drop key art' }}</span>
                        @endif
                    </div>
                    <div class="game-card__body">
                        <div class="game-card__tags">
                            <span class="badge badge--{{ $game['status'] }}">{{ $game['status_label'] }}</span>
                            <span class="badge-meta">{{ $game['meta'] }}</span>
                        </div>
                        <h2 class="game-card__title">{{ $game['title'] }}</h2>
                        <p class="game-card__blurb">{{ $game['blurb'] }}</p>
                        <a href="{{ $game['href'] }}" class="game-card__link">{{ $game['link_label'] }} <span aria-hidden="true">→</span></a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>