<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Bridge\AccessToken;

class PlayerTest extends TestCase
{

    public function test_user_login()
    {   
        $response = $this->post('/api/login', [
            'email' => 'p1@admin.net',
            'password' => '123456',
        ]);  
        return $response->assertStatus(201);
    }

    /** 
    * @depends test_user_login
    */

    //User not authorized
    public function test_returns_list_of_players_with_success_rate($response)
    {
       $token = $response['token'];
       $response = $this->withHeaders([
        'Authorization' => 'Bearer '. $token,
        'Accept' => 'application/json'
    ])->get('/api/players/');
    $response->assertStatus(403);
    }

    /** 
    * @depends test_user_login
    */
       //User not authorized
       public function test_return_winner($response)
       {
          $token = $response['token'];
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/ranking/winner');
       $response->assertStatus(403);
       }


    /** 
    * @depends test_user_login
    */
       //User not authorized
       public function test_return_loser($response)
       {
          $token = $response['token'];
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/ranking/loser');
       $response->assertStatus(403);
       }

    /** 
    * @depends test_user_login
    */
       //User not authorized
       public function test_return_ranks($response)
       {
          $token = $response['token'];
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/ranking');
       $response->assertStatus(403);
       }

    /** 
    * @depends test_user_login
    */
       //Player can  play the game
       public function test_user_rolls_dice($response)
       {
          $token = $response['token'];
          $id = $response->json(['user', 'id']);
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->post('/api/players/' . $id . '/games');
       $response->assertStatus(200);
       }

    /** 
    * @depends test_user_login
    */
       //Player not authorized to delete games
       public function test_user_delete_games($response)
       {
          $token = $response['token'];
          $id = $response->json(['user', 'id']);
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->delete('/api/players/' . $id . '/games');
       $response->assertStatus(200);
       }

    /** 
    * @depends test_user_login
    */
       //Player get list of his games
       public function test_user_show_games($response)
       {
          $token = $response['token'];
          $id = $response->json(['user', 'id']);
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->get('/api/players/' . $id);
       $response->assertStatus(200);
       }

       
    /** 
    * @depends test_user_login
    */
       //Player modify name
       public function test_user_modify_name($response)
       {
          $token = $response['token'];
          $id = $response->json(['user', 'id']);
          $response = $this->withHeaders([
           'Authorization' => 'Bearer '. $token,
           'Accept' => 'application/json'
       ])->put('/api/players/' . $id, [
         'name' => 'Player1 name modified by test'
     ]);
       $response->assertStatus(200);
       }
}

