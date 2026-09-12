@extends('admin.layout')

@section('title', 'Hero')

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="crumb">← Dashboard</a>
            <h1>Hero section</h1>
            <p>The headline block at the top of the page.</p>
        </div>
    </div>

    <form class="form" method="POST" action="{{ route('admin.hero.update') }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="eyebrow">Eyebrow</label>
            <input id="eyebrow" type="text" name="eyebrow" value="{{ old('eyebrow', $hero['eyebrow'] ?? '') }}">
            @error('eyebrow') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="title_lines">Title lines <span class="hint">— one line per row; the site stacks them</span></label>
            <textarea id="title_lines" name="title_lines" rows="3">{{ old('title_lines', implode("\n", $hero['title_lines'] ?? [])) }}</textarea>
            @error('title_lines') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="title_accent">Accent line <span class="hint">— the exact line to highlight in orange</span></label>
            <input id="title_accent" type="text" name="title_accent" value="{{ old('title_accent', $hero['title_accent'] ?? '') }}">
            @error('title_accent') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="body">Intro paragraph</label>
            <textarea id="body" name="body" rows="4">{{ old('body', $hero['body'] ?? '') }}</textarea>
            @error('body') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label>Stats <span class="hint">— the little value / label pairs</span></label>
            <div class="repeater" id="stats">
                @php $stats = old('stat_value') ? array_map(null, old('stat_value'), old('stat_label')) : array_map(fn($s) => [$s['value'] ?? '', $s['label'] ?? ''], $hero['stats'] ?? []); @endphp
                @forelse ($stats as $stat)
                    <div class="repeater__row">
                        <input type="text" name="stat_value[]" value="{{ $stat[0] ?? '' }}" placeholder="6+">
                        <input type="text" name="stat_label[]" value="{{ $stat[1] ?? '' }}" placeholder="Projects shipped">
                        <button type="button" class="repeater__del" onclick="this.closest('.repeater__row').remove()">Remove</button>
                    </div>
                @empty
                    <div class="repeater__row">
                        <input type="text" name="stat_value[]" value="" placeholder="6+">
                        <input type="text" name="stat_label[]" value="" placeholder="Projects shipped">
                        <button type="button" class="repeater__del" onclick="this.closest('.repeater__row').remove()">Remove</button>
                    </div>
                @endforelse
            </div>
            <button type="button" class="btn btn--ghost btn--sm" style="margin-top:10px;" id="add-stat">+ Add stat</button>
        </div>

        <div class="form__actions">
            <button type="submit" class="btn btn--primary">Save hero</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.getElementById('add-stat')?.addEventListener('click', function () {
        var row = document.createElement('div');
        row.className = 'repeater__row';
        row.innerHTML = '<input type="text" name="stat_value[]" placeholder="6+">'
            + '<input type="text" name="stat_label[]" placeholder="Projects shipped">'
            + '<button type="button" class="repeater__del">Remove</button>';
        row.querySelector('.repeater__del').addEventListener('click', function () { row.remove(); });
        document.getElementById('stats').appendChild(row);
    });
</script>
@endpush
