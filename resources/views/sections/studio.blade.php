<section class="section" aria-labelledby="studio-title">
    <div class="container studio__inner">
        <div class="studio__top">
            <div class="studio__copy" data-reveal>
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