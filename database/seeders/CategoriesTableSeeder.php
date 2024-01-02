<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Baba',
            'Blondynki',
            'Erotyczne',
            'O Jasiu',
            'Brunetki'

            // Add more categories as needed
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
