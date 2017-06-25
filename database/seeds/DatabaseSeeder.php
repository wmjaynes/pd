<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Organization;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RoleSeeder::class);

        DB::unprepared(file_get_contents(app_path() . "/../database/seeds/convert_pd.sql"));

        User::create([
            'name' => 'Will Jaynes',
            'email' => 'will@jaynes.org',
            'userid' => 'wmjaynes',
            'password' => 'william',
            'superuser' => 1,
//            'activeOrganization' => 135,
        ]);

        $users = \App\User::all();
        foreach ($users as $user) {
            $user->password = Hash::make($user->password);
            $user->save();
        }

        $org = Organization::find(135);
        $org2 = Organization::find(1);
        $role = \App\Role::find(3);
        $user = User::where('email', 'will@jaynes.org')->first();
        \Illuminate\Support\Facades\Log::debug('dbseeder - user' . $user);
//        $user->organizations()->attach($org);
        $user->organizations()->save($org, ['role_id'=>$role->id] );
        $user->organizations()->save($org2, ['role_id'=>2] );
        $user->currentOrganization()->associate($org);
        $user->save();
//        $user->organizations->pivot->role = $role;


    }
}
