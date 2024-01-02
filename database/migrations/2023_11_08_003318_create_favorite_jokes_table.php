<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteJokesTable extends Migration
{
    public function up()
    {   
        Schema::dropIfExists('favorite_jokes');
        Schema::create('favorite_jokes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('joke_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Each user can only favorite a joke once
            $table->unique(['user_id', 'joke_id']);
        });
    }

    // ...
}
