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
            ['no' => 'T01', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T02', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T03', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T04', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T05', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T06', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T07', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T08', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T09', 'capacity' => 5, 'status' => 'available'],
            ['no' => 'T10', 'capacity' => 5, 'status' => 'available'],
        ]);
    }
}
