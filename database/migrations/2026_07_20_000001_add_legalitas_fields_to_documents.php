<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('number', 190)->nullable()->after('title');
            $table->string('file_path')->nullable()->change();
        });

        Schema::table('document_categories', function (Blueprint $table) {
            $table->boolean('is_legal')->default(false)->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('number');
            // file_path is left nullable on rollback: reverting to NOT NULL
            // could fail on rows seeded without an uploaded file.
        });

        Schema::table('document_categories', function (Blueprint $table) {
            $table->dropColumn('is_legal');
        });
    }
};
