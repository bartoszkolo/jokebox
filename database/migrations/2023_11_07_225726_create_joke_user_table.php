<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('joke_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('joke_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('vote', ['up', 'down']); // 'up' for upvote, 'down' for downvote
            $table->timestamps();
            
            $table->unique(['joke_id', 'user_id']); // Prevent multiple votes for the same joke by the same user
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joke_user');
    }
};
