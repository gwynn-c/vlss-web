<footer class="site-footer">
    <div class="site-footer__inner">
        <span class="site-footer__brand">{{ config('site.name') }}</span>
        <nav class="site-footer__links" aria-label="Footer">
            <a href="{{ route('privacy') }}">Privacy Policy</a>
        </nav>
        <span class="site-footer__meta">© {{ date('Y') }} — Built by people who test their own builds.</span>
    </div>
</footer>
