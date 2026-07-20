<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'file_size_kb' => 'integer',
            'download_count' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Whether this document has an uploaded file that actually exists on disk.
     * Legalitas records may exist (label + number) before their PDF is uploaded.
     */
    public function hasFile(): bool
    {
        return ! empty($this->file_path) && Storage::disk('public')->exists($this->file_path);
    }

    /**
     * @return BelongsTo<DocumentCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }
}
