<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJokesTable extends Migration
{
    public function up()
    {
        Schema::create('jokes', function (Blueprint $table) {
            $table->id();
            $table->text('text');  // The text of the joke
            $table->unsignedBigInteger('category_id'); // ID of the category
            $table->unsignedBigInteger('user_id'); // ID of the user who posted the joke
            $table->integer('upvotes')->default(0); // Number of upvotes
            $table->integer('downvotes')->default(0); // Number of downvotes
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jokes');
    }
}
