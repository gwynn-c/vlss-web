<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Support\SiteContent;

class DashboardController extends Controller
{
    public function index()
    {
        $sections = collect(config('admin.sections'))
            ->map(fn ($config, $key) => [
                'key' => $key,
                'label' => $config['label'],
                'icon' => $config['icon'] ?? '•',
                'blurb' => $config['blurb'] ?? '',
                'count' => count(SiteContent::items($key)),
            ])
            ->values()
            ->all();

        $submissionCount = ContactSubmission::count();

        return view('admin.dashboard', compact('sections', 'submissionCount'));
    }
}
