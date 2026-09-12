@extends('admin.layout')

@section('title', 'Site settings')

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="crumb">← Dashboard</a>
            <h1>Site settings</h1>
            <p>Contact address, studio meta and social links. Leave a social link empty to hide its button.</p>
        </div>
    </div>

    <form class="form" method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="contact_email">Contact email <span class="hint">— where the contact form is delivered</span></label>
            <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $site['contact_email'] ?? '') }}">
            @error('contact_email') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="grid-2">
            <div class="field">
                <label for="name">Studio name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $site['name'] ?? '') }}">
                @error('name') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="tagline">Tagline</label>
                <input id="tagline" type="text" name="tagline" value="{{ old('tagline', $site['tagline'] ?? '') }}">
                @error('tagline') <div class="err">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="field">
            <label for="description">Meta description <span class="hint">— used in &lt;head&gt; and social previews</span></label>
            <textarea id="description" name="description" rows="3">{{ old('description', $site['description'] ?? '') }}</textarea>
            @error('description') <div class="err">{{ $message }}</div> @enderror
        </div>

        <h2 style="font-size:16px;margin:24px 0 12px;">Social links</h2>
        <div class="grid-2">
            @foreach (['discord' => 'Discord', 'bluesky' => 'Bluesky', 'youtube' => 'YouTube', 'itch' => 'itch.io'] as $key => $label)
                <div class="field">
                    <label for="s-{{ $key }}">{{ $label }}</label>
                    <input id="s-{{ $key }}" type="text" name="socials[{{ $key }}]"
                           value="{{ old('socials.'.$key, $site['socials'][$key] ?? '') }}" placeholder="https://…">
                    @error('socials.'.$key) <div class="err">{{ $message }}</div> @enderror
                </div>
            @endforeach
        </div>

        <div class="form__actions">
            <button type="submit" class="btn btn--primary">Save settings</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
@endsection
