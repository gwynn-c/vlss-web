@extends('admin.layout')

@section('title', 'Submission from '.$submission->name)

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('admin.submissions.index') }}" class="crumb">← Contact submissions</a>
            <h1>{{ $submission->name }}</h1>
            <p>Received {{ $submission->created_at?->format('M j, Y \a\t g:i a') }}</p>
        </div>
        <a href="mailto:{{ $submission->email }}" class="btn btn--primary">Reply by email</a>
    </div>

    <div class="form">
        <dl class="details">
            <dt>Name</dt>
            <dd>{{ $submission->name }}</dd>

            <dt>Email</dt>
            <dd><a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></dd>

            <dt>Studio / company</dt>
            <dd>{{ $submission->company ?: '—' }}</dd>

            <dt>About</dt>
            <dd>{{ $submission->topic ?: '—' }}</dd>

            <dt>Budget</dt>
            <dd>{{ $submission->budget ?: '—' }}</dd>

            <dt>IP address</dt>
            <dd>{{ $submission->ip_address ?: '—' }}</dd>
        </dl>

        <h2 class="details__heading">The pitch</h2>
        <div class="details__message">{{ $submission->message }}</div>

        <div class="form__actions" style="margin-top:22px;">
            <a href="{{ route('admin.submissions.index') }}" class="btn btn--ghost">Back</a>
            <span class="spacer"></span>
            <form method="POST" action="{{ route('admin.submissions.destroy', $submission) }}"
                  onsubmit="return confirm('Delete this submission? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--danger">Delete submission</button>
            </form>
        </div>
    </div>
@endsection
