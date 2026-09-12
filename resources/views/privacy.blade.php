@extends('layouts.app')

@section('title', 'Privacy Policy — ' . config('site.name'))
@section('meta_description', 'How ' . config('site.name') . ' collects, uses, and protects your data. No advertising, no data selling, no tracking cookies.')

@section('content')
    <section class="legal" aria-labelledby="legal-title">
        <div class="legal__inner">
            <header class="legal__head" data-reveal>
                <span class="eyebrow eyebrow--teal no-rule">Legal</span>
                <h1 class="section-title" id="legal-title">Privacy Policy</h1>
                <p class="legal__updated">Last updated {{ \Illuminate\Support\Carbon::parse(config('site.privacy_updated', '2026-09-12'))->format('F j, Y') }}</p>
                <p class="legal__lede">
                    {{ config('site.name') }} runs this website to show our work and let people
                    get in touch. This page explains what the site collects, why, and what we do
                    with it. We keep the list short on purpose — we only take what a contact form
                    and a working website actually need.
                </p>
            </header>

            <div class="legal__body" data-reveal>
                <h2>Who we are</h2>
                <p>
                    This policy covers the website at
                    <a href="{{ route('home') }}">{{ preg_replace('~^https?://~', '', config('app.url', 'verylongswordstudio.com')) }}</a>,
                    operated by {{ config('site.name') }} (“we”, “us”, “our”). For any privacy
                    question, email us at
                    <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a>.
                </p>

                <h2>What we collect</h2>
                <p>We only collect information in two situations:</p>
                <ul>
                    <li>
                        <strong>When you use the contact form.</strong> We collect the details you
                        type in — your name, email address, optional studio or company name, the
                        topic and budget range you pick, and your message. These are sent to us so
                        we can reply.
                    </li>
                    <li>
                        <strong>Basic request data.</strong> Like any website, our server and our
                        hosting/CDN provider record standard technical details when a page or the
                        contact form is loaded — such as your IP address, browser type, and the
                        time of the request. We attach the IP address to a contact submission to
                        help us detect spam and abuse.
                    </li>
                </ul>
                <p>
                    We do <strong>not</strong> run advertising, we do not sell your data, and we do
                    not build advertising or behavioural profiles about you.
                </p>

                <h2>How we use it</h2>
                <ul>
                    <li>To read your message and get back to you about your enquiry.</li>
                    <li>To keep a record of enquiries so we can follow up.</li>
                    <li>To keep the site working, secure, and free of spam and abuse.</li>
                </ul>

                <h2>Our stack &amp; the services behind this site</h2>
                <p>
                    Being upfront about the technology matters for privacy, so here is what
                    actually powers this site:
                </p>
                <ul>
                    <li>
                        <strong>Application &amp; hosting.</strong> The site is a
                        <strong>Laravel</strong> (PHP) application served over HTTPS. It runs behind
                        <strong>nginx</strong> and <strong>Cloudflare</strong>, which sit in front of
                        the site to serve traffic securely and filter malicious requests. Your
                        request data passes through these providers as part of delivering the page.
                    </li>
                    <li>
                        <strong>Contact form delivery.</strong> When you submit the form, your
                        message is emailed to our studio inbox and may also be stored in our own
                        database so we do not lose it. Nothing you send is passed to an
                        advertising network.
                    </li>
                    <li>
                        <strong>Fonts.</strong> The site loads the “Chivo” typeface from
                        <strong>Google Fonts</strong>. When a font file is fetched, Google may
                        receive your IP address and the page you are on. Our display typeface is
                        served from our own server, so it does not involve a third party.
                    </li>
                </ul>

                <h2>Cookies</h2>
                <p>
                    We do not use tracking, advertising, or analytics cookies. The only cookies
                    this site sets are the strictly necessary ones Laravel uses to keep your
                    session and to protect the contact form against cross-site request forgery
                    (CSRF). These are essential for the form to work and are not used to follow you
                    across other websites.
                </p>

                <h2>How long we keep it</h2>
                <p>
                    We keep contact enquiries only as long as we need them to handle your request
                    and for a reasonable period afterwards for our records. You can ask us to delete
                    your enquiry at any time and we will do so unless we are required to keep it.
                    Standard server and CDN logs are kept for a short, rolling window and then
                    rotated out.
                </p>

                <h2>Who we share it with</h2>
                <p>
                    We do not sell or rent your information. We only share it with the service
                    providers described above (hosting/CDN, email delivery, and Google Fonts) to
                    the extent needed to run the site and reply to you, or where we are legally
                    required to disclose it.
                </p>

                <h2>Your choices</h2>
                <ul>
                    <li>You can email us to ask what we hold about you, correct it, or delete it.</li>
                    <li>You are never required to use the contact form — you can email us directly instead.</li>
                    <li>You can block or clear cookies in your browser; the site will still load, though the contact form needs its essential cookies to submit.</li>
                </ul>

                <h2>Children</h2>
                <p>
                    This site is aimed at studios, collaborators, and people interested in our work.
                    It is not directed at children, and we do not knowingly collect personal
                    information from children under 13. If you believe a child has sent us their
                    information, contact us and we will delete it.
                </p>

                <h2>Changes to this policy</h2>
                <p>
                    If our practices change, we will update this page and change the “last updated”
                    date above. Significant changes will be made clear here.
                </p>

                <h2>Contact</h2>
                <p>
                    Questions about privacy or a request about your data? Email
                    <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a>.
                </p>

                <p class="legal__back">
                    <a href="{{ route('home') }}">← Back to {{ config('site.name') }}</a>
                </p>
            </div>
        </div>
    </section>
@endsection
