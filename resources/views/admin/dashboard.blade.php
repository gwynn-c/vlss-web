@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="page-head">
        <div>
            <h1>Dashboard</h1>
            <p>Edit everything the landing page shows. Changes go live immediately.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn--ghost btn--sm">View site ↗</a>
    </div>

    <div class="cards">
        <a class="card" href="{{ route('admin.hero.edit') }}">
            <span class="card__icon">✨</span>
            <div class="card__title">Hero</div>
            <div class="card__meta">Headline, intro copy & stats</div>
        </a>

        @foreach ($sections as $section)
            <a class="card" href="{{ route('admin.sections.index', $section['key']) }}">
                <span class="card__count">{{ $section['count'] }}</span>
                <span class="card__icon">{{ $section['icon'] }}</span>
                <div class="card__title">{{ $section['label'] }}</div>
                <div class="card__meta">{{ $section['blurb'] }}</div>
            </a>
        @endforeach

        <a class="card" href="{{ route('admin.settings.edit') }}">
            <span class="card__icon">⚙️</span>
            <div class="card__title">Site settings</div>
            <div class="card__meta">Contact email & social links</div>
        </a>
    </div>
@endsection
