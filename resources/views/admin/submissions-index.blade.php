@extends('admin.layout')

@section('title', 'Contact submissions')

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="crumb">← Dashboard</a>
            <h1>Contact submissions</h1>
            <p>Everything sent through the contact form on the site, newest first.</p>
        </div>
    </div>

    @if ($submissions->isEmpty())
        <div class="empty">No submissions yet.</div>
    @else
        <div class="list">
            @foreach ($submissions as $submission)
                <div class="row">
                    <div class="row__main">
                        <div class="row__title">
                            <a href="{{ route('admin.submissions.show', $submission) }}" class="row__link">{{ $submission->name }}</a>
                            @if ($submission->topic)
                                <span class="badge">{{ $submission->topic }}</span>
                            @endif
                        </div>
                        <div class="row__sub">
                            {{ $submission->email }}@if ($submission->company) · {{ $submission->company }}@endif
                            · {{ \Illuminate\Support\Str::limit($submission->message, 90) }}
                        </div>
                    </div>

                    <span class="row__date" title="{{ $submission->created_at?->format('M j, Y g:i a') }}">{{ $submission->created_at?->format('M j, Y') }}</span>

                    <div class="row__actions">
                        <a href="{{ route('admin.submissions.show', $submission) }}" class="btn btn--ghost btn--sm">View</a>
                        <form method="POST" action="{{ route('admin.submissions.destroy', $submission) }}"
                              onsubmit="return confirm('Delete this submission? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn--danger btn--sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($submissions->hasPages())
            <nav class="pager" aria-label="Pagination">
                @if ($submissions->onFirstPage())
                    <span class="btn btn--ghost btn--sm is-disabled">← Newer</span>
                @else
                    <a href="{{ $submissions->previousPageUrl() }}" class="btn btn--ghost btn--sm">← Newer</a>
                @endif

                <span class="pager__info">Page {{ $submissions->currentPage() }} of {{ $submissions->lastPage() }} · {{ $submissions->total() }} total</span>

                @if ($submissions->hasMorePages())
                    <a href="{{ $submissions->nextPageUrl() }}" class="btn btn--ghost btn--sm">Older →</a>
                @else
                    <span class="btn btn--ghost btn--sm is-disabled">Older →</span>
                @endif
            </nav>
        @endif
    @endif
@endsection
