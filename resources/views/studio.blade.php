@extends('layouts.app')

@section('title', 'Studio — '.config('site.name'))

@section('meta_description', 'How Very Longsword Studio works — the pillars, the proof, and what partners say.')

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => '03 — Studio',
        'title' => 'A small studio<br>with a long sword',
        'lede' => 'Very Longsword Studio designs and builds games, from the first scribbled mechanic to the build you can actually put in someone\'s hands. We work with indie teams and AA studios on original projects, co-development, and fast proof of concepts.',
    ])

    @include('sections.studio')
@endsection