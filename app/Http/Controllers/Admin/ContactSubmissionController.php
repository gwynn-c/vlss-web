<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactSubmissionController extends Controller
{
    /**
     * Messages sent through the public contact form, newest first.
     */
    public function index(): View
    {
        $submissions = ContactSubmission::query()
            ->latest()
            ->latest('id')
            ->paginate(20);

        return view('admin.submissions-index', compact('submissions'));
    }

    public function show(ContactSubmission $submission): View
    {
        return view('admin.submissions-show', compact('submission'));
    }

    /**
     * Delete a submission (e.g. spam, or a data-deletion request per the privacy policy).
     */
    public function destroy(ContactSubmission $submission): RedirectResponse
    {
        $submission->delete();

        return redirect()
            ->route('admin.submissions.index')
            ->with('status', 'Submission deleted.');
    }
}
