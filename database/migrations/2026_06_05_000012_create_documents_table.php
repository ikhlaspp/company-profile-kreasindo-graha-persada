<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_category_id')->nullable()
                ->constrained('document_categories')->nullOnDelete()->cascadeOnUpdate();
            $table->string('title', 200);
            $table->string('file_path');
            $table->unsignedInteger('file_size_kb')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->year('year')->nullable();
            $table->unsignedInteger('download_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
