<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Laravel\Passport\Bridge\AccessToken;

use function PHPUnit\Framework\assertTrue;

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
 
        return $response->assertStatus(201)->json(['user', 'id']);
    }

    /**
     * @depends test_user_login
     * 
     */

    public function test_user_logout($id)
    {
       $RefreshTokenRepository = app(\Laravel\Passport\RefreshTokenRepository::class);
       foreach(User::find($id)->tokens as $token) {
           $token->revoke();
           $RefreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
       }  
       $this->addToAssertionCount(1); 
    }  

    public function test_user_login_with_bad_credentials()
    {   
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.net',
            'password' => '1234567',
        ]);  
 
        return $response->assertStatus(401);
    }
}

