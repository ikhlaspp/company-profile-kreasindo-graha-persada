<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('kgp_image')) {
    /**
     * Resolve an image URL for guest pages.
     *
     * Prefers a real uploaded file on the public disk; otherwise falls back to a
     * deterministic placeholder photo (same seed always yields the same image,
     * so slots don't flicker between page loads).
     *
     * @param  string|null  $path  Stored relative path (e.g. "projects/foo.jpg").
     * @param  string  $seed  Stable seed for the placeholder (e.g. "proj-12").
     * @param  int  $w  Width in pixels.
     * @param  int  $h  Height in pixels.
     */
    function kgp_image(?string $path, string $seed, int $w = 1200, int $h = 800): string
    {
        if (! empty($path) && Storage::disk('public')->exists($path)) {
            return asset('storage/'.$path);
        }

        return 'https://picsum.photos/seed/'.urlencode($seed).'/'.$w.'/'.$h;
    }
}
