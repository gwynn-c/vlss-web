@extends('layouts.app')

@section('title', 'Contact — '.config('site.name'))

@section('meta_description', 'Pitch a project, kick off co-development, or get a prototype looked at. We reply within two working days.')

@section('content')
    @include('sections.contact')
@endsection