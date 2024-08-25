<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Food', 'image' => 'https://cdn-icons-png.flaticon.com/512/147/147144.png'],
            ['name' => 'Beverage', 'image' => 'https://cdn-icons-png.flaticon.com/512/147/147144.png'],
            ['name' => 'Dessert', 'image' => 'https://cdn-icons-png.flaticon.com/512/147/147144.png'],
        ]);
    }
}
