<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testOrderSuccess(): void
    {

        Auth::attempt(['email' => 'admin@gmail.com', 'password' => '123456789']);

        $user = Auth::user();

        $this->postJson('/api/orders', [
            'cart_item_id' => 23,
            'reservation_id' => 6,
            'total_payment' => 100000,
            'status' => 'new'
        ], [
            'Authorization' => $user->token
        ])->assertStatus(201)->assertJson([
            'data' => [
                'cart_item' => [
                    'id' => 23,
                    'cart_id' => 1,
                    'menu_id' => 14,
                    'quantity' => 1,
                    'notes' => NULL,
                ],
                'reservation' => [
                    'id' => 6,
                    'user_id' => 2,
                    'table_id' => 1,
                    'date' => '2000-05-21',
                    'time' => '03:00:00',
                    'persons' => 123,
                    'status' => 'pending',
                    'notes' => 'Optional notes about the reservation',
                ],
                'status' => 'new',
                'total_payment' => 100000
            ]
        ]);
    }
}
