@php($socials = config('site.socials'))

<section class="contact" id="contact" aria-labelledby="contact-title">
    <div class="contact__grid">
        <div class="contact__info" data-reveal>
            <span class="eyebrow eyebrow--teal no-rule">05 — Contact</span>
            <h2 class="section-title" id="contact-title">Tell us what<br>you're building</h2>
            <p class="contact__lede">Pitches, co-dev, a prototype you need looked at — all welcome. We reply within two working days, even when the answer is no.</p>

            <div class="contact__card">
                <span class="contact__card-label">Rather just talk?</span>
                <a href="#contact" class="contact__call">Book a 30-min call →</a>
                <span class="contact__email-line">Or email <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a></span>
            </div>

            <div class="socials">
                @if($socials['discord'])<a href="{{ $socials['discord'] }}" class="btn btn-outline btn-sm social-btn social-btn--discord">Discord</a>@endif
                @if($socials['bluesky'])<a href="{{ $socials['bluesky'] }}" class="btn btn-outline btn-sm social-btn social-btn--bluesky">Bluesky</a>@endif
                @if($socials['youtube'])<a href="{{ $socials['youtube'] }}" class="btn btn-outline btn-sm social-btn social-btn--youtube">YouTube</a>@endif
                @if($socials['itch'])<a href="{{ $socials['itch'] }}" class="btn btn-outline btn-sm social-btn social-btn--itch">itch.io</a>@endif
            </div>
        </div>

        <form class="form" method="POST" action="{{ route('contact.store') }}" data-reveal novalidate>
            @csrf

            @if (session('contact_sent'))
                <div class="form-alert" data-form-alert role="status">
                    <span aria-hidden="true">✓</span> Got it — we'll be in touch within two working days.
                </div>
            @endif

            <div class="form__row">
                <label class="field @error('name') field--error @enderror">
                    <span class="field__label">Name</span>
                    <input name="name" type="text" placeholder="Jane Swordsmith" value="{{ old('name') }}" required>
                    @error('name')<span class="field__error">{{ $message }}</span>@enderror
                </label>
                <label class="field @error('company') field--error @enderror">
                    <span class="field__label">Studio / company</span>
                    <input name="company" type="text" placeholder="Optional" value="{{ old('company') }}">
                    @error('company')<span class="field__error">{{ $message }}</span>@enderror
                </label>
            </div>

            <label class="field @error('email') field--error @enderror">
                <span class="field__label">Email</span>
                <input name="email" type="email" placeholder="you@studio.com" value="{{ old('email') }}" required>
                @error('email')<span class="field__error">{{ $message }}</span>@enderror
            </label>

            <div class="form__row">
                <label class="field">
                    <span class="field__label">This is about</span>
                    <select name="topic">
                        @foreach (['Co-development','Original project / publishing','Prototype or proof of concept','Press','Joining the team','Something else'] as $opt)
                            <option @selected(old('topic') === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Budget range</span>
                    <select name="budget">
                        @foreach (['Not sure yet','Under $10k','$10k – $50k','$50k – $150k','$150k+'] as $opt)
                            <option @selected(old('budget') === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label class="field @error('message') field--error @enderror">
                <span class="field__label">The pitch</span>
                <textarea name="message" rows="5" placeholder="What is it, where is it, and what's the part you're stuck on?" required>{{ old('message') }}</textarea>
                @error('message')<span class="field__error">{{ $message }}</span>@enderror
            </label>

            {{-- Honeypot: hidden from humans, catches bots --}}
            <div class="hp" aria-hidden="true">
                <label>Leave this empty <input name="website" type="text" tabindex="-1" autocomplete="off"></label>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top:4px;justify-content:center;">Send the pitch</button>
            <span class="form__note">We reply within two working days, even when the answer is no.</span>
        </form>
    </div>
</section>
