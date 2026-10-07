@extends('layouts.app')

@section('title', 'Careers — '.config('site.name'))

@section('meta_description', 'Open roles at Very Longsword Studio. Remote-friendly, small team, short meetings.')

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => '05 — Careers',
        'title' => 'Open roles',
        'lede' => 'Remote-friendly, small team, short meetings. Portfolio over résumé, always.',
    ])

    @include('sections.careers')
@endsection