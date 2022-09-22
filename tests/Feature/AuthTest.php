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
    
    protected function newUser() {
        //parent::setUp();
        return $this->user = User::factory()->make();
    }

    public function test_new_users_can_register()
    {
       $this->user = $this->newUser();
       $response = $this->post('/api/players/', [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => $this->user->password,
            'password_confirmation' => $this->user->password,
            'role' => 'player'
        ]);
       $response->assertStatus(201);
       return $this->user;
       
    }

    /** 
    * @depends test_new_users_can_register
    */

    public function test_user_login($user)
    {   
        $this->user = $user;
        //dd($this->user->email);
        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => $this->user->password,
        ]);  
 
        return $response->assertStatus(201);
    }

    /**
     * @depends test_user_login
     * 
     */

    public function test_user_logout($response)
    {   
        $this->id = $response->json(['user', 'id']);
        $this->response = $response;
        $this->token = $this->response['token'];
        $this->response = $this->withHeaders([
         'Authorization' => 'Bearer '. $this->token,
         'Accept' => 'application/json'
     ])->post('/api/logout');
     $response->assertStatus(201);
    
    }  

    /** 
    * @depends test_new_users_can_register
    */

    public function test_user_login_with_bad_credentials($user)
    {   
        $this->user = $user;
        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => (String)rand(123456, 123499),
        ]);   
 
        return $response->assertStatus(401);
    }
}

