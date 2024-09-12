<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [];

        for ($i = 0; $i < 5; $i++) {
            $orders[] = [
                'id' => Str::ulid(), // Membuat ULID sebagai primary key
                'user_id' => 1, // Mengisi user_id dengan 1
                'token' => Str::random(10), // Membuat token acak
                'reservation_id' => 1, // Mengisi reservation_id dengan 1
                'status' => 'new', // Status diisi 'new'
                'total_payment' => 100000, // Mengisi total_payment dengan default 12
                'created_at' => now(), // Tanggal pembuatan
                'updated_at' => now(), // Tanggal pembaruan
            ];
        }

        DB::table('orders')->insert($orders);
    }
}
