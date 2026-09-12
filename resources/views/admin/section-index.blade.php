@extends('admin.layout')

@section('title', $config['label'])

@php
    // Pick sensible fields to display in each row.
    $imageField = collect($config['fields'])->search(fn ($f) => $f['type'] === 'image');
    $imageField = $imageField === false ? null : $imageField;
    $textKeys   = collect($config['fields'])->reject(fn ($f) => $f['type'] === 'image')->keys();
    $titleField = $textKeys->first();
    $subField   = $textKeys->skip(1)->first();
    $hasStatus  = isset($config['fields']['status']);
@endphp

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="crumb">← Dashboard</a>
            <h1>{{ $config['label'] }}</h1>
            <p>{{ $config['blurb'] ?? '' }}</p>
        </div>
        <a href="{{ route('admin.sections.create', $section) }}" class="btn btn--primary">+ Add {{ strtolower($config['singular']) }}</a>
    </div>

    @if (count($items) === 0)
        <div class="empty">
            No {{ strtolower($config['label']) }} yet.
            <a href="{{ route('admin.sections.create', $section) }}">Add the first one</a>.
        </div>
    @else
        <div class="list" id="sortable" data-reorder-url="{{ route('admin.sections.reorder', $section) }}">
            @foreach ($items as $item)
                <div class="row" data-id="{{ $item['id'] }}">
                    <span class="row__grip" title="Drag to reorder">⠿</span>

                    @if ($imageField)
                        @if (!empty($item[$imageField]))
                            <img class="row__thumb" src="{{ asset($item[$imageField]) }}" alt="">
                        @else
                            <span class="row__thumb">no image</span>
                        @endif
                    @endif

                    <div class="row__main">
                        <div class="row__title">
                            {{ $item[$titleField] ?? '(untitled)' }}
                            @if ($hasStatus && !empty($item['status']))
                                <span class="badge badge--{{ $item['status'] }}">{{ $item['status_label'] ?? $item['status'] }}</span>
                            @endif
                        </div>
                        @if ($subField && !empty($item[$subField]))
                            <div class="row__sub">{{ \Illuminate\Support\Str::limit($item[$subField], 90) }}</div>
                        @endif
                    </div>

                    <div class="row__actions">
                        <a href="{{ route('admin.sections.edit', [$section, $item['id']]) }}" class="btn btn--ghost btn--sm">Edit</a>
                        <form method="POST" action="{{ route('admin.sections.destroy', [$section, $item['id']]) }}"
                              onsubmit="return confirm('Remove this {{ strtolower($config['singular']) }}? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn--danger btn--sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="card__meta" style="margin-top:14px;">Drag rows by the ⠿ handle to reorder. Order saves automatically.</p>
    @endif
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"></script>
<script>
    (function () {
        var list = document.getElementById('sortable');
        if (!list || typeof Sortable === 'undefined') return;

        Sortable.create(list, {
            handle: '.row__grip',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function () {
                var order = Array.from(list.querySelectorAll('.row')).map(function (r) { return r.dataset.id; });
                fetch(list.dataset.reorderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order: order }),
                });
            },
        });
    })();
</script>
@endpush
