<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = User::create([

            'name' => 'admin',
            'email' => 'admin@admin.net',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
            
        ])->assignRole('admin');

        Game::create(['user_id' => $user['id']]);

        $user = User::create([

            'name' => 'Player1',
            'email' => 'p1@admin.net',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),

        ])->assignRole('player');

        Game::create(['user_id' => $user['id']]);

        $user = User::create([

            'name' => 'Player2',
            'email' => 'p2@admin.net',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),

        ])->assignRole('player');

        Game::create(['user_id' => $user['id']]);
        
        $user = User::create([

            'name' => 'Player3',
            'email' => 'p3@admin.net',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),

        ])->assignRole('player');

        Game::create(['user_id' => $user['id']]);
    }
}
