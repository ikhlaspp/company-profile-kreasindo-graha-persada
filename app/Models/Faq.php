<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faq extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'hit_count' => 'integer',
        ];
    }

    /**
     * @return HasMany<ChatLog, $this>
     */
    public function chatLogs(): HasMany
    {
        return $this->hasMany(ChatLog::class);
    }
}
