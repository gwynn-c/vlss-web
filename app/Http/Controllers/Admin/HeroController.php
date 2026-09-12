<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteContent;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function edit()
    {
        return view('admin.hero', [
            'hero' => config('content.hero', []),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'eyebrow'      => ['nullable', 'string', 'max:200'],
            'title_lines'  => ['nullable', 'string', 'max:1000'],
            'title_accent' => ['nullable', 'string', 'max:200'],
            'body'         => ['nullable', 'string', 'max:2000'],
            'stat_value'   => ['array'],
            'stat_value.*' => ['nullable', 'string', 'max:60'],
            'stat_label'   => ['array'],
            'stat_label.*' => ['nullable', 'string', 'max:120'],
        ]);

        // Title lines: one per line in the textarea.
        $lines = collect(preg_split('/\r\n|\r|\n/', $data['title_lines'] ?? ''))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();

        // Stats: pair up value/label rows, dropping empty ones.
        $stats = [];
        foreach ($data['stat_value'] ?? [] as $i => $value) {
            $label = $data['stat_label'][$i] ?? null;
            if (($value ?? '') === '' && ($label ?? '') === '') {
                continue;
            }
            $stats[] = ['value' => $value ?? '', 'label' => $label ?? ''];
        }

        SiteContent::put('hero', [
            'eyebrow'      => $data['eyebrow'] ?? '',
            'title_lines'  => $lines,
            'title_accent' => $data['title_accent'] ?? '',
            'body'         => $data['body'] ?? '',
            'stats'        => $stats,
        ]);

        return redirect()
            ->route('admin.hero.edit')
            ->with('status', 'Hero section saved.');
    }
}
