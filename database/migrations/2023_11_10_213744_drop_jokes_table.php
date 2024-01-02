<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropJokesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('jokes');
    }

    public function down()
    {
        // You can recreate the jokes table here if you want to be able to rollback this migration.
        // However, if the original table creation is handled in another migration, you might leave this empty.
    }
}
