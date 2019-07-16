<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Organization;
use App\Tag;

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

//        User::create([
//            'name' => 'Super User',
//            'email' => 'super@super.org',
//            'password' => Hash::make('super'),
//            'superuser' => 1,
//        ]);

        if ($seedLevel == 'minimal')
            return;

        DB::unprepared(file_get_contents(app_path() . "/../database/seeds/convert_pd.sql"));


//        $users = \App\User::all();
//        foreach ($users as $user) {
//            $user->password = Hash::make($user->password);
//            $user->save();
//        }

        User::create([
            'name' => 'Will Jaynes',
            'email' => 'will@jaynes.org',
            'password' => Hash::make('jaynes'),
            'superuser' => 1,
        ]);
        User::create([
            'name' => 'Robert Messer',
            'email' => 'ram@albion.edu',
            'password' => Hash::make('jaynes'),
            'superuser' => 0,
        ]);

        $org = Organization::find(135);
        $org2 = Organization::find(797);
//        $org2 = Organization::find(1);
        $will = User::where('email', 'will@jaynes.org')->first();
        $bob = User::where('email', 'ram@albion.edu')->first();
//        $will->superuser = true;
        $will->addOrganization($org);
        $bob->addOrganization($org2);
        $bob->addApprovedOrganization($org);
//        $bob->save();
//        $will->organizations()->save($org2);
        $will->currentOrganization()->associate($org);
        $will->save();
//
        Tag::create(['tag' => "AACTMAD Event Calendar"]);
        Tag::create(['tag' => "Dance"]);
        Tag::create(['tag' => "Contra"]);
        Tag::create(['tag' => "English Country"]);
        Tag::create(['tag' => "Square"]);
        Tag::create(['tag' => "International"]);
        Tag::create(['tag' => "Scandinavian"]);
        Tag::create(['tag' => "Couple"]);
        Tag::create(['tag' => "Family"]);
        Tag::create(['tag' => "Community"]);
        Tag::create(['tag' => "Waltz"]);
        Tag::create(['tag' => "Concert"]);
        Tag::create(['tag' => "Music Jam"]);
        Tag::create(['tag' => "Open Band"]);
        Tag::create(['tag' => "Weekend"]);
        Tag::create(['tag' => "Week"]);
        Tag::create(['tag' => "Meeting"]);


    }
}
