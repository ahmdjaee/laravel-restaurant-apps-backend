<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Food',
                'image' => 'categories/TNqx39rTgzUYf1iQNNqYngG6XblJPfIuaL8Y8GrJ.jpg',
                'created_at' => now()
            ],
            [
                'name' => 'Beverage',
                'image' => 'categories/UUD6UyIbVjwADSuis3lTjKYzsi0kdQKh2lSFuq2T.jpg',
                'created_at' => now()
            ],
            [
                'name' => 'Dessert',
                'image' => 'categories/2jJP0kdz8lZfCza2qFvLX6554v8x7n3xQLPDQFjf.jpg',
                'created_at' => now()
            ],
        ]);
    }
}
