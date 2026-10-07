{{-- Page header for the standalone sections. $title may contain <br> (trusted copy from config). --}}
<section class="page-hero" aria-labelledby="page-title" data-reveal>
    <div class="container">
        <span class="eyebrow eyebrow--steel">{{ $eyebrow }}</span>
        <h1 class="page-hero__title" id="page-title">{!! $title !!}</h1>
        @if (!empty($lede))
            <p class="page-hero__lede">{{ $lede }}</p>
        @endif
    </div>
</section>