<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Bridge\AccessToken;

class AdminTest extends TestCase
{

    public function test_admin_login()
    {   
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.net',
            'password' => '123456',
        ]);  
        //dd($response->json('id'));
        return $response->assertStatus(201);
    }

    /** 
    * @depends test_admin_login
    */

    //Admin only
    public function test_returns_list_of_players_with_success_rate($response)
    {
       $token = $response['token'];
       $response = $this->withHeaders([
        'Authorization' => 'Bearer '. $token,
        'Accept' => 'application/json'
    ])->get('/api/players/');
    $response->assertStatus(200);
    }

    /** 
    * @depends test_admin_login
    */
       //Admin only
       public function test_return_winner($response)
       {
          $token = $response['token'];
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/ranking/winner');
       $response->assertStatus(200);
       }


    /** 
    * @depends test_admin_login
    */
       //Admin only
       public function test_return_loser($response)
       {
          $token = $response['token'];
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/ranking/loser');
       $response->assertStatus(200);
       }

        /** 
    * @depends test_admin_login
    */
       //Admin only
       public function test_return_ranks($response)
       {
          $token = $response['token'];
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/ranking');
       $response->assertStatus(200);
       }

    /** 
    * @depends test_admin_login
    */
       //Admin can not play the game
       public function test_admin_rolls_dice($response)
       {
         //dd($response->json('id'));
          $token = $response['token'];
          $id = $response->json('id');
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->post('/api/players/' . $id . '/games');
       $response->assertStatus(403);
       }

    /** 
    * @depends test_admin_login
    */
       //Admin can delete games
       public function test_admin_delete_games($response)
       {
          $token = $response['token'];
          $id = $response->json('id');
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->delete('/api/players/' . $id . '/games');
       $response->assertStatus(200);
       }

    /** 
    * @depends test_admin_login
    */
       //Admin get list of games
       public function test_admin_show_games($response)
       {
          $token = $response['token'];
          $id = $response->json('id');
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/' . $id);
       $response->assertStatus(200);
       }

       
    /** 
    * @depends test_admin_login
    */
       //Admin modify name
       public function test_admin_modify_name($response)
       {
          $token = $response['token'];
          $id = $response->json('id');
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'])
           ->put('/api/players/' . $id, [
            'name' => 'Admin name modified by test'
        ]);
       $response->assertStatus(200);
       }


}
