<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    
    public function test_new_users_can_register()
    {
       $user = User::factory()->make();
       $response = $this->post('/api/players/', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'role' => 'player'
        ]);
       $response->assertStatus(201);
    }


    public function test_user_login()
    {   
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.net',
            'password' => '123456',
        ]);  
        $response->assertStatus(201);
        return $token = ($response->json(['token']));
    }

    /**
     * @depends test_user_login
     */

    public function test_user_logout($token)
    {
       $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/logout');
       //dd($response);
       $response->assertStatus(200);
    }  
}

