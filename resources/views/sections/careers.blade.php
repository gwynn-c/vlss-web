<section class="section section--alt" aria-labelledby="careers-title">
    <div class="container">
        <div class="careers__list">
            @foreach ($roles as $role)
                <a href="{{ route('contact') }}" class="role" data-reveal>
                    <div>
                        <span class="role__title">{{ $role['title'] }}</span>
                        <div class="role__detail">{{ $role['detail'] }}</div>
                    </div>
                    <span class="role__apply">Apply →</span>
                </a>
            @endforeach
            <p class="careers__foot" data-reveal>Nothing fits but you're good? <a href="{{ route('contact') }}">Send work anyway</a> — we keep a short list.</p>
        </div>
    </div>
</section>