@extends('layouts.app')

@section('title', 'Services — '.config('site.name'))

@section('meta_description', 'Full-cycle game development, co-development, proof of concepts, systems design and production rescue.')

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => '02 — Services',
        'title' => 'What you can<br>hand us',
        'lede' => 'Got something half-formed? Bring it. We\'ll help you find the edge.',
    ])

    @include('sections.services')
@endsection