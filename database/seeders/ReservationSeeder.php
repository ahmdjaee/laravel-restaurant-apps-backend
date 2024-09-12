<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $reservations = [];
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        
        for ($i = 0; $i < 5; $i++) {
            $reservations[] = [
                'user_id' => 1, // Mengisi user_id secara acak, misal antara 1 hingga 10
                'table_id' => rand(1, 10), // Mengisi table_id secara acak, misal antara 1 hingga 10
                'date' => now()->addDays($i), // Mengisi tanggal dengan hari ini ditambah offset
                'time' => now()->format('H:i:s'), // Mengisi waktu saat ini
                'persons' => rand(1, 6), // Jumlah orang acak antara 1 hingga 6
                'status' => $statuses[array_rand($statuses)], // Status acak dari array $statuses
                'notes' => 'Reservation note ' . ($i + 1), // Catatan dengan teks yang berbeda untuk setiap entri
                'created_at' => now(), // Tanggal pembuatan
                'updated_at' => now(), // Tanggal pembaruan
            ];
        }

        DB::table('reservations')->insert($reservations);
    }
}
