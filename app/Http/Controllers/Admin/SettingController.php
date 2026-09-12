<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteContent;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', [
            'site' => config('site', []),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'contact_email'   => ['nullable', 'email', 'max:180'],
            'name'            => ['nullable', 'string', 'max:120'],
            'tagline'         => ['nullable', 'string', 'max:200'],
            'description'     => ['nullable', 'string', 'max:1000'],
            'socials.discord' => ['nullable', 'string', 'max:300'],
            'socials.bluesky' => ['nullable', 'string', 'max:300'],
            'socials.youtube' => ['nullable', 'string', 'max:300'],
            'socials.itch'    => ['nullable', 'string', 'max:300'],
        ]);

        // Empty social => '' hides that button (matches the Blade guards).
        $socials = [];
        foreach (['discord', 'bluesky', 'youtube', 'itch'] as $key) {
            $socials[$key] = $data['socials'][$key] ?? '';
        }

        SiteContent::put('site', [
            'contact_email' => $data['contact_email'] ?? config('site.contact_email'),
            'name'          => $data['name'] ?? config('site.name'),
            'tagline'       => $data['tagline'] ?? config('site.tagline'),
            'description'   => $data['description'] ?? config('site.description'),
            'socials'       => $socials,
        ]);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Site settings saved.');
    }
}
