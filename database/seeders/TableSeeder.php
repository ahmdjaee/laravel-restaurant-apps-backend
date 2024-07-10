<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Table::insert([
            ['no' => '1', 'capacity' => 5, 'status' => 'available'],
            ['no' => '2', 'capacity' => 5, 'status' => 'available'],
            ['no' => '3', 'capacity' => 5, 'status' => 'available'],
            ['no' => '4', 'capacity' => 5, 'status' => 'available'],
            ['no' => '5', 'capacity' => 5, 'status' => 'available'],
            ['no' => '6', 'capacity' => 5, 'status' => 'available'],
            ['no' => '7', 'capacity' => 5, 'status' => 'available'],
            ['no' => '8', 'capacity' => 5, 'status' => 'available'],
            ['no' => '9', 'capacity' => 5, 'status' => 'available'],
            ['no' => '10', 'capacity' => 5, 'status' => 'available'],
        ]);
    }
}
