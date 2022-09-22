<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //Roles and permissions
        $this->call(RoleSeeder::class);

        //Users base
        $this->call(UserSeeder::class);


       //  User::factory(5)->create()->each(function($user) {
       //      $user->assignRole('player');
       //     Game::create(['user_id' => $user['id']]);
       // });

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
