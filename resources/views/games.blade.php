@extends('layouts.app')

@section('title', 'Games — '.config('site.name'))

@section('meta_description', 'A look at what we\'ve shipped: original projects, co-development, and fast proof of concepts.')

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => '01 — Products',
        'title' => 'The showcase',
        'lede' => 'Some ours, some built with partners. All of them playable — we don\'t ship slideware.',
    ])

    @include('sections.games')
@endsection