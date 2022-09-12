<?php

namespace Database\Seeders;

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
      /*  User::create([

            'name' => 'admin',
            'email' => 'admin@admin.net',
            'email_verified_at' => now(),
            'password' => '123456', // password
            'remember_token' => Str::random(10),
            
        ])->assignRole('admin');

        User::create([

            'name' => 'Player1',
            'email' => 'player_1@admin.net',
            'email_verified_at' => now(),
            'password' => '123456', // password
            'remember_token' => Str::random(10),

        ])->assignRole('player');

        User::create([

            'name' => 'Player2',
            'email' => 'player_2@admin.net',
            'email_verified_at' => now(),
            'password' => '123456', // password
            'remember_token' => Str::random(10),

        ])->assignRole('player');*/
    }
}
