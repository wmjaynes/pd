<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{

    public function run()
    {
        DB::table('roles')->delete();

        Role::create([
            'name' => 'observer'
        ]);

        Role::create([
            'name' => 'editor'
        ]);

        Role::create([
            'name' => 'administrator'
        ]);

    }
}
