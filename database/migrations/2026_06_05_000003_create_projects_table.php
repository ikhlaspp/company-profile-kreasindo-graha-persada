<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()
                ->constrained('clients')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->nullable()
                ->constrained('services')->nullOnDelete()->cascadeOnUpdate();
            $table->enum('division', ['it', 'interior', 'sipil']);
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('contract_value')->nullable();
            $table->string('location', 150)->nullable();
            $table->year('year')->nullable();
            $table->date('completed_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('division');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
