<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->enum('division', ['it', 'interior', 'me', 'umum']);
            $table->string('title', 150);
            $table->string('slug', 170)->unique();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'internship'])->default('full_time');
            $table->string('location', 150)->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('division');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
