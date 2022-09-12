<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    
    
    public function test_new_users_can_register()
    {
        $response = $this->post('/api/players/', [
            'name' => 'TestUser',
            'email' => 'test000@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 'player'
        ]);

        //$this->assertAuthenticated();
        //$this->withoutExceptionHandling();
        $response->assertStatus(201);
 
    }
}
