<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('keywords')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedInteger('hit_count')->default(0);
            $table->timestamps();

            $table->index('is_active');
        });

        // FULLTEXT search (question, keywords) — MySQL only.
        if (DB::getDriverName() === 'mysql') {
            Schema::table('faqs', function (Blueprint $table) {
                $table->fullText(['question', 'keywords'], 'ft_faqs_question_keywords');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
