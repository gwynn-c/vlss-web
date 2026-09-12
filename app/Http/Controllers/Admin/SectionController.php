<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends Controller
{
    /** Resolve a section's schema or 404. */
    protected function schema(string $section): array
    {
        return config("admin.sections.$section")
            ?? abort(Response::HTTP_NOT_FOUND, "Unknown section [$section].");
    }

    public function index(string $section)
    {
        $config = $this->schema($section);

        return view('admin.section-index', [
            'section' => $section,
            'config'  => $config,
            'items'   => SiteContent::items($section),
        ]);
    }

    public function create(string $section)
    {
        $config = $this->schema($section);

        return view('admin.section-form', [
            'section' => $section,
            'config'  => $config,
            'item'    => null,
        ]);
    }

    public function store(string $section, Request $request)
    {
        $config = $this->schema($section);
        $data   = $this->validated($section, $config, $request);

        $item = ['id' => SiteContent::newId()];
        $item = $this->fill($item, $config, $data, $request);

        $items   = SiteContent::items($section);
        $items[] = $item;
        $this->persist($section, $config, $items);

        return redirect()
            ->route('admin.sections.index', $section)
            ->with('status', $config['singular'].' added.');
    }

    public function edit(string $section, string $id)
    {
        $config = $this->schema($section);
        $item   = SiteContent::item($section, $id) ?? abort(404);

        return view('admin.section-form', compact('section', 'config', 'item'));
    }

    public function update(string $section, string $id, Request $request)
    {
        $config = $this->schema($section);
        $data   = $this->validated($section, $config, $request);

        $items = SiteContent::items($section);
        foreach ($items as &$item) {
            if (($item['id'] ?? null) === $id) {
                $item = $this->fill($item, $config, $data, $request);
                break;
            }
        }
        unset($item);

        $this->persist($section, $config, $items);

        return redirect()
            ->route('admin.sections.index', $section)
            ->with('status', $config['singular'].' updated.');
    }

    public function destroy(string $section, string $id)
    {
        $config = $this->schema($section);
        $items  = SiteContent::items($section);

        $items = array_values(array_filter($items, function (array $item) use ($id, $config) {
            if (($item['id'] ?? null) === $id) {
                $this->deleteImages($config, $item);

                return false;
            }

            return true;
        }));

        $this->persist($section, $config, $items);

        return redirect()
            ->route('admin.sections.index', $section)
            ->with('status', $config['singular'].' removed.');
    }

    /** Persist a new order given a list of ids. */
    public function reorder(string $section, Request $request)
    {
        $config = $this->schema($section);
        $order  = $request->input('order', []);
        $items  = SiteContent::items($section);

        $byId = [];
        foreach ($items as $item) {
            $byId[$item['id'] ?? ''] = $item;
        }

        $reordered = [];
        foreach ($order as $id) {
            if (isset($byId[$id])) {
                $reordered[] = $byId[$id];
                unset($byId[$id]);
            }
        }
        // Append anything not named in the order (safety).
        foreach ($byId as $item) {
            $reordered[] = $item;
        }

        $this->persist($section, $config, $reordered);

        return response()->json(['ok' => true]);
    }

    // ---- helpers ---------------------------------------------------------

    protected function validated(string $section, array $config, Request $request): array
    {
        $rules = [];

        foreach ($config['fields'] as $name => $field) {
            if ($field['type'] === 'image') {
                $rules[$name] = ['nullable', 'image', 'max:5120']; // 5 MB
                continue;
            }

            $set = ['nullable', 'string', 'max:5000'];
            if ($field['type'] === 'url') {
                $set = ['nullable', 'string', 'max:500'];
            }
            if ($field['type'] === 'select') {
                $set = ['nullable', Rule::in(array_keys($field['options']))];
            }
            if (! empty($field['required'])) {
                $set[0] = 'required';
            }
            $rules[$name] = $set;
        }

        return $request->validate($rules);
    }

    /** Apply validated data (and uploaded/removed images) onto an item. */
    protected function fill(array $item, array $config, array $data, Request $request): array
    {
        foreach ($config['fields'] as $name => $field) {
            if ($field['type'] === 'image') {
                $item[$name] = $this->resolveImage($name, $field, $item, $request);
                continue;
            }

            $value = $data[$name] ?? null;
            $item[$name] = $value;

            // A select can drive a companion label field (status -> status_label).
            if ($field['type'] === 'select' && ! empty($field['sets_label']) && $value !== null) {
                $item[$field['sets_label']] = $field['options'][$value] ?? $value;
            }
        }

        return $item;
    }

    protected function resolveImage(string $name, array $field, array $item, Request $request): ?string
    {
        $current = $item[$name] ?? null;

        // Explicit removal.
        if ($request->boolean("remove_$name")) {
            $this->deleteImageFile($current);

            return null;
        }

        if (! $request->hasFile($name)) {
            return $current; // unchanged
        }

        $file      = $request->file($name);
        $dir       = public_path('img/uploads');
        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $filename  = Str::slug($item['id'] ?? Str::uuid()).'-'.now()->timestamp.'.'.$file->getClientOriginalExtension();
        $file->move($dir, $filename);

        $this->deleteImageFile($current); // clean up the replaced file

        return 'img/uploads/'.$filename;
    }

    protected function deleteImages(array $config, array $item): void
    {
        foreach ($config['fields'] as $name => $field) {
            if ($field['type'] === 'image') {
                $this->deleteImageFile($item[$name] ?? null);
            }
        }
    }

    protected function deleteImageFile(?string $path): void
    {
        // Only ever delete files we manage under img/uploads.
        if ($path && Str::startsWith($path, 'img/uploads/')) {
            $full = public_path($path);
            if (is_file($full)) {
                @unlink($full);
            }
        }
    }

    /** Apply auto-numbering, then save the section. */
    protected function persist(string $section, array $config, array $items): void
    {
        if (! empty($config['auto_number'])) {
            $field = $config['auto_number'];
            $n = 1;
            foreach ($items as &$item) {
                $item[$field] = str_pad((string) $n++, 2, '0', STR_PAD_LEFT);
            }
            unset($item);
        }

        SiteContent::put($section, array_values($items));
    }
}
