<section class="section" id="studio" aria-labelledby="studio-title">
    <div class="container studio__inner">
        <div class="studio__top">
            <div class="studio__copy" data-reveal>
                <span class="eyebrow eyebrow--teal no-rule">03 — About us</span>
                <h2 class="section-title" id="studio-title">A small studio<br>with a long sword</h2>
                <p>Very Longsword Studio designs and builds games, from the first scribbled mechanic to the build you can actually put in someone's hands. We work with indie teams and AA studios on original projects, co-development, and fast proof of concepts.</p>
                <p>We're small on purpose. The people who pitch your project are the people who build it — no handoff, no account manager translating "make it juicier" into a ticket.</p>
            </div>

            <div class="pillars" data-reveal>
                @foreach ($pillars as $pillar)
                    <div class="pillar">
                        <span class="pillar__title pillar__title--{{ $pillar['color'] }}">{{ $pillar['title'] }}</span>
                        <span class="pillar__body">{{ $pillar['body'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="team">
            <h3 class="eyebrow eyebrow--dim no-rule" data-reveal>The people</h3>
            <div class="team__grid">
                @foreach ($team as $member)
                    <div class="team-card" data-reveal>
                        <div class="team-card__photo">
                            @if (!empty($member['image']))
                                <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}">
                            @else
                                <span class="img-slot">{{ $member['image_hint'] ?? 'Drop a portrait' }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="team-card__name">{{ $member['name'] }}</div>
                            <div class="team-card__role">{{ $member['role'] }}</div>
                            <div class="team-card__note">{{ $member['note'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="quotes">
            @foreach ($quotes as $quote)
                <blockquote class="quote" data-reveal>
                    <p>“{{ $quote['text'] }}”</p>
                    <footer>
                        <span class="quote__who">{{ $quote['who'] }}</span><br>
                        <span class="quote__where">{{ $quote['where'] }}</span>
                    </footer>
                </blockquote>
            @endforeach
        </div>
    </div>
</section>
