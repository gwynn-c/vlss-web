<?php

namespace App\Http\Controllers;

use App\Mail\ContactSubmitted;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email'   => ['required', 'email', 'max:180'],
            'topic'   => ['nullable', 'string', 'max:120'],
            'budget'  => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:5000'],
            // Honeypot: real users leave this empty. Bots fill everything.
            'website' => ['nullable', 'size:0'],
        ]);

        $attributes = [
            'name'       => $data['name'],
            'company'    => $data['company'] ?? null,
            'email'      => $data['email'],
            'topic'      => $data['topic'] ?? null,
            'budget'     => $data['budget'] ?? null,
            'message'    => $data['message'],
            'ip_address' => $request->ip(),
        ];

        // Persisting to a database is optional — this site can run without one.
        // If a DB is configured we store the submission; otherwise we still email it.
        $submission = new ContactSubmission($attributes);
        $submission->created_at = now();
        try {
            $submission->save();
        } catch (\Throwable $e) {
            report($e);
        }

        Mail::to(config('site.contact_email'))->send(new ContactSubmitted($submission));

        return back()->with('contact_sent', true);
    }
}
