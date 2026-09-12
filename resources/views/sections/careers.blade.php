<section class="section section--alt" id="careers" aria-labelledby="careers-title">
    <div class="container">
        <div class="section__head" data-reveal>
            <div class="section__head-copy">
                <span class="eyebrow eyebrow--purple no-rule">04 — Careers</span>
                <h2 class="section-title" id="careers-title">Open roles</h2>
            </div>
            <p class="section__note">Remote-friendly, small team, short meetings. Portfolio over résumé, always.</p>
        </div>

        <div class="careers__list">
            @foreach ($roles as $role)
                <a href="#contact" class="role" data-reveal>
                    <div>
                        <span class="role__title">{{ $role['title'] }}</span>
                        <div class="role__detail">{{ $role['detail'] }}</div>
                    </div>
                    <span class="role__apply">Apply →</span>
                </a>
            @endforeach
            <p class="careers__foot" data-reveal>Nothing fits but you're good? <a href="#contact">Send work anyway</a> — we keep a short list.</p>
        </div>
    </div>
</section>
