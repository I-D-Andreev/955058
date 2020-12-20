<?php

use Illuminate\Database\Seeder;
use App\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = new Profile;
        $profile->phone_number = '123-456-789';
        $profile->user_id = 1;
        $profile->save();
        factory(Profile::class, 5)->create();
    }
}
