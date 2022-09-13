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
        $user = User::factory()->create();
                $user->assignRole('player');
                
        //dd($user->email);
        $response = $this->post('/api/players/', [
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'role' => $user->roles[0]['name']
        ]);

        Game::create(['user_id' => $user['id']]);
        //$this->assertAuthenticated();
        //$this->withoutExceptionHandling();
        $response->assertStatus(201);
 
    }

    public function test_user_login()
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.net',
            'password' => '123456',
        ]);

        //$this->assertAuthenticated();
        //$this->withoutExceptionHandling();
        $response->assertStatus(201);
 
    }

    /* public function test_user_logout()
    {
        $response = $this->post('/api/logout');


        $this->withoutExceptionHandling();
        //$this->assertAuthenticated();
        $response->assertStatus(200);
 
    } */
}


