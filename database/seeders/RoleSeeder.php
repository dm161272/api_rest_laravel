<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        Admin => all but play game
        Player => play, view personal statistics, delete personal results
        */

        $admin = Role::create(['name' => 'admin']);
        $player = Role::create(['name' => 'player']);

        //Permission::create(['name' => 'login'])->syncRoles([$admin, $player]);
        
        Permission::create(['name' => 'players.store'])->syncRoles([$admin, $player]);
        Permission::create(['name' => 'logout'])->syncRoles([$admin, $player]);
        Permission::create(['name' => 'players.list'])->syncRoles([$admin]);
        Permission::create(['name' => 'players.winner'])->syncRoles([$admin]);
        Permission::create(['name' => 'players.loser'])->syncRoles([$admin]);
        Permission::create(['name' => 'players.ranks'])->syncRoles([$admin]);
        Permission::create(['name' => 'games.list'])->syncRoles([$admin, $player]);
        Permission::create(['name' => 'players.update'])->syncRoles([$admin, $player]);
        Permission::create(['name' => 'players.game'])->syncRoles([$player]);
        Permission::create(['name' => 'games.delete'])->syncRoles([$admin, $player]);


    }
    
}
