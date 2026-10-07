@extends('layouts.app')

@section('title', 'Team — '.config('site.name'))

@section('meta_description', 'The people of Very Longsword Studio, grouped by discipline: engineering, art and design.')

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => '04 — Team',
        'title' => 'The people',
        'lede' => 'Small on purpose: no handoff, no account managers. Just the designers, artists and engineers who build the thing.',
    ])

    <div class="blade-rule" aria-hidden="true"></div>

    @include('sections.team')
@endsection