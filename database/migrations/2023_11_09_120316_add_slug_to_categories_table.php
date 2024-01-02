<?php

use App\Models\Category;
use Illuminate\Support\Str;
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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->default('')->after('name');
        });
        
        // Now that we have a default value, let's set the actual slugs
        Category::where('slug', '')->get()->each(function ($category) {
            $category->slug = Str::slug($category->name);
            $category->save();
        });
        
        // After setting all slugs, we can now change the column to not null
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
};
