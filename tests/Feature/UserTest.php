<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess()
    {
        $this->post('/api/users/register', [
            'name' => 'John Doe',
            'email' => 'j@j.com',
            'password' => '12345678'
        ])->assertStatus(201)->assertJson([
            'data' => [
                'name' => 'John Doe',
                'email' => 'j@j.com',
                'token' => null
            ]
        ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/users/register', [
            'name' => '',
            'email' => 'salah',
            'password' => 'salah'
        ])->assertStatus(400)->assertJson([
            'errors' =>[
                'name' => ['The name field is required.'],
                'email' => ['The email field must be a valid email address.'],
                'password' => ['The password field must be at least 8 characters.'],
            ]
        ]);
    }
}
