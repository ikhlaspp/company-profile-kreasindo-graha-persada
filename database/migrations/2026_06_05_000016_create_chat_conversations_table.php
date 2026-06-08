<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->unique();
            $table->string('visitor_ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};
