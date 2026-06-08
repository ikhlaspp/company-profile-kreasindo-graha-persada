<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Widen chat_logs.source to include the Grok fallback layer and the static
     * "fallback" reply (Task 3.5). Portable across MySQL (enum) and SQLite
     * (CHECK constraint) via Laravel's native column change.
     */
    public function up(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            $table->enum('source', ['faq', 'gemini', 'grok', 'fallback'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            $table->enum('source', ['faq', 'gemini'])->change();
        });
    }
};
