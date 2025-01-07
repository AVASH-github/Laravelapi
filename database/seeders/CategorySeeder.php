<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => "Men's clothing", 'status' => 'active'],
            ['name' => "Women's clothing", 'status' => 'active'],
        ];

        Category::insert($categories);
    }
}
