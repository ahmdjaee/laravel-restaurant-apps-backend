<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('events')->insert([
            [
                'title' => 'Big Summer Promo',
                'description' => 'Get up to 50% off on selected items this summer!',
                'type' => 'Promo',
                'image' => 'events/big_summer_promo.jpg',
                'event_start' => '2024-06-01 00:00:00',
                'event_end' => '2024-06-30 23:59:59',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Live Acoustic Concert',
                'description' => 'Enjoy a night of live acoustic music with local artists.',
                'type' => 'Concert',
                'image' => 'events/acoustic_concert.jpg',
                'event_start' => '2024-07-15 19:00:00',
                'event_end' => '2024-07-15 22:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Baking Workshop for Beginners',
                'description' => 'Learn the basics of baking with our expert pastry chef.',
                'type' => 'Workshop',
                'image' => 'events/baking_workshop.jpg',
                'event_start' => '2024-08-05 10:00:00',
                'event_end' => '2024-08-05 13:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Food Lovers Festival',
                'description' => 'A festival featuring gourmet food from top local chefs.',
                'type' => 'Festival',
                'image' => 'events/food_festival.jpg',
                'event_start' => '2024-09-10 12:00:00',
                'event_end' => '2024-09-10 18:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Midnight Flash Sale',
                'description' => 'Exclusive midnight sale with discounts up to 70% off!',
                'type' => 'Flash Sale',
                'image' => 'events/midnight_flash_sale.jpg',
                'event_start' => '2024-10-15 00:00:00',
                'event_end' => '2024-10-15 03:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Autumn Concert Extravaganza',
                'description' => 'A grand concert to celebrate the beauty of autumn.',
                'type' => 'Concert',
                'image' => 'events/autumn_concert.jpg',
                'event_start' => '2024-11-01 18:00:00',
                'event_end' => '2024-11-01 21:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Winter Flash Sale',
                'description' => 'Don’t miss out on our winter flash sale! Huge discounts await.',
                'type' => 'Flash Sale',
                'image' => 'events/winter_flash_sale.jpg',
                'event_start' => '2024-12-05 10:00:00',
                'event_end' => '2024-12-05 12:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Christmas Promo',
                'description' => 'Celebrate the season with special discounts on selected menus.',
                'type' => 'Promo',
                'image' => 'events/christmas_promo.jpg',
                'event_start' => '2024-12-20 00:00:00',
                'event_end' => '2024-12-25 23:59:59',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'New Year’s Eve Concert',
                'description' => 'Celebrate New Year with live performances from top bands.',
                'type' => 'Concert',
                'image' => 'events/new_year_concert.jpg',
                'event_start' => '2024-12-31 20:00:00',
                'event_end' => '2025-01-01 01:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Healthy Cooking Workshop',
                'description' => 'Learn to cook healthy and delicious meals with our nutritionist.',
                'type' => 'Workshop',
                'image' => 'events/healthy_cooking_workshop.jpg',
                'event_start' => '2024-02-15 14:00:00',
                'event_end' => '2024-02-15 17:00:00',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
