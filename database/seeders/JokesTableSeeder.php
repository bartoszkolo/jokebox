<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Joke;
use App\Models\User;
use App\Models\Category;
use League\Csv\Reader;

class JokesTableSeeder extends Seeder
{
    public function run()
    {
        $csv = Reader::createFromPath(__DIR__.'/perelka.csv', 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Joke::create([
                'text' => $record['Joke'],
                'category_id' => Category::inRandomOrder()->first()->id, // Assign a random category
                'user_id' => User::inRandomOrder()->first()->id, // Assign a random user
                'upvotes' => $record['Rating'] ?? 0, // Use Rating as upvotes, if available
                'downvotes' => 0, // Default downvotes to 0
            ]);
        }
    }
}
