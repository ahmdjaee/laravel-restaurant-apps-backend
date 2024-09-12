<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan semua order ID yang telah dibuat
        $orderIds = DB::table('orders')->pluck('id');

        $orderItems = [];
        $menuIds = range(1, 10); // Menu ID dari 1 sampai 10

        foreach ($orderIds as $orderId) {
            // Membuat 5 entri untuk setiap order
            for ($i = 0; $i < 5; $i++) {
                $orderItems[] = [
                    'menu_id' => $menuIds[array_rand($menuIds)], // Memilih menu_id secara acak dari 1 sampai 10
                    'order_id' => $orderId, // Mengaitkan dengan order_id yang ada
                    'quantity' => rand(1, 10), // Jumlah acak antara 1 hingga 10
                    'price' => rand(1000, 5000), // Harga acak antara 1000 hingga 5000
                    'created_at' => now(), // Tanggal pembuatan
                    'updated_at' => now(), // Tanggal pembaruan
                ];
            }
        }

        DB::table('order_items')->insert($orderItems);
    }
}
