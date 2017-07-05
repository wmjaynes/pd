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
        $seedLevel = env('DB_SEED_LEVEL', 'minimal');
        $this->call(RoleSeeder::class);

        User::create([
            'name' => 'Super User',
            'email' => 'super@super.org',
            'password' => Hash::make('super'),
            'superuser' => 1,
        ]);

        if ($seedLevel == 'minimal')
            return;

        DB::unprepared(file_get_contents(app_path() . "/../database/seeds/convert_pd.sql"));


//        $users = \App\User::all();
//        foreach ($users as $user) {
//            $user->password = Hash::make($user->password);
//            $user->save();
//        }

        $org = Organization::find(135);
        $org2 = Organization::find(1);
        $role = \App\Role::find(3);
        $will = User::where('email', 'will@jaynes.org')->first();
        $will->superuser = true;
//        \Illuminate\Support\Facades\Log::debug('dbseeder - user' . $user);
        $will->organizations()->save($org, ['role_id'=>$role->id] );
        $will->organizations()->save($org2, ['role_id'=>2] );
        $will->currentOrganization()->associate($org);
        $will->save();


    }
}
