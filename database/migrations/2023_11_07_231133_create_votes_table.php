<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('joke_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('vote')->comment('1 for upvote, -1 for downvote');
            $table->timestamps();
            
            // Ensure that a user can only vote once per joke
            $table->unique(['joke_id', 'user_id'], 'user_joke_vote_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
};
