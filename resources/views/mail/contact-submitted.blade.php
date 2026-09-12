<x-mail::message>
# New pitch from the website

**Name:** {{ $submission->name }}
@if($submission->company)
**Studio / company:** {{ $submission->company }}
@endif
**Email:** {{ $submission->email }}
@if($submission->topic)
**About:** {{ $submission->topic }}
@endif
@if($submission->budget)
**Budget:** {{ $submission->budget }}
@endif

**The pitch:**

{{ $submission->message }}

<x-mail::button :url="'mailto:'.$submission->email">
Reply to {{ $submission->name }}
</x-mail::button>

Sent {{ $submission->created_at?->format('M j, Y g:i a') }} · IP {{ $submission->ip_address }}
</x-mail::message>
