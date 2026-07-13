<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| Ubah kolom "source" dari enum tetap menjadi string bebas.
| Tujuannya agar nilai provider baru (openai, deepseek, dll) bisa disimpan
| tanpa perlu mengubah skema enum setiap menambah provider.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            $table->string('source', 32)->default('fallback')->change();
        });
    }

    public function down(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            $table->enum('source', ['faq', 'gemini', 'grok', 'fallback'])->change();
        });
    }
};