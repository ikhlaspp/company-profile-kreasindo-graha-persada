<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait InteractsWithResource
{
    /**
     * Menghasilkan slug unik untuk model tertentu berdasarkan sumber string.
     */
    protected function uniqueSlug(string $modelClass, string $source, ?string $given = null, ?int $ignoreId = null): string
    {
        $base = Str::slug($given ?: $source) ?: 'item';
        $slug = $base;
        $i = 2;

        while (
            $modelClass::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /**
     * Simpan file unggahan dan hapus file lama jika ada. Kembalikan path baru atau lama jika tidak ada unggahan baru.
     */
    protected function storeFile(Request $request, string $field, string $folder, ?string $old = null): ?string
    {
        if ($request->hasFile($field)) {
            if ($old) {
                Storage::disk('public')->delete($old);
            }

            return $request->file($field)->store($folder, 'public');
        }

        return $old;
    }
}
