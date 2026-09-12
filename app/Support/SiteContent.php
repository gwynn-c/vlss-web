<?php

namespace App\Support;

use App\Models\ContentSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Reads and writes the editable site content stored in `content_settings`,
 * falling back to the static config/content.php + config/site.php defaults.
 *
 * At boot (applyOverrides) it pushes stored values back into config() so the
 * public controllers and Blade views keep reading config('content.*') and
 * config('site.*') without knowing the database exists.
 */
class SiteContent
{
    /** List-type sections stored as an array of items, each with an `id`. */
    public const LIST_SECTIONS = ['games', 'services', 'pillars', 'team', 'quotes', 'roles'];

    public const CACHE_KEY = 'content_overrides';

    /**
     * Merge any stored overrides into the runtime config. Called from the
     * service provider on every request; safe before the table exists.
     */
    public static function applyOverrides(): void
    {
        try {
            if (! Schema::hasTable('content_settings')) {
                return;
            }

            $overrides = Cache::rememberForever(self::CACHE_KEY, function () {
                return ContentSetting::query()->pluck('value', 'key')->all();
            });
        } catch (\Throwable $e) {
            return; // DB not ready (e.g. during migrate) — use config defaults.
        }

        foreach ($overrides as $key => $value) {
            if ($value === null) {
                continue;
            }

            if ($key === 'site') {
                // Site settings are a map: merge over defaults so partial saves work.
                config(['site' => array_replace_recursive(config('site', []), $value)]);
            } else {
                // Content sections are replaced wholesale (lists / the hero object).
                config(["content.$key" => $value]);
            }
        }
    }

    /** Current effective value for a content section (stored or config default). */
    public static function get(string $key): mixed
    {
        return config("content.$key");
    }

    /**
     * Items of a list section, each guaranteed to carry a stable `id`.
     * The first read of a section seeds the database from the config default.
     */
    public static function items(string $section): array
    {
        $stored = ContentSetting::query()->where('key', $section)->first();

        if ($stored) {
            return array_values($stored->value ?? []);
        }

        $items = array_map(function (array $item) {
            $item['id'] = self::newId();

            return $item;
        }, config("content.$section", []));

        self::put($section, $items);

        return $items;
    }

    /** Find a single item within a list section by its id. */
    public static function item(string $section, string $id): ?array
    {
        foreach (self::items($section) as $item) {
            if (($item['id'] ?? null) === $id) {
                return $item;
            }
        }

        return null;
    }

    /** Persist a section value and refresh the runtime overrides. */
    public static function put(string $key, mixed $value): void
    {
        ContentSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        self::flush();
    }

    /** The site settings map (stored merged over config defaults). */
    public static function site(): array
    {
        return config('site', []);
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function newId(): string
    {
        return (string) Str::uuid();
    }
}
