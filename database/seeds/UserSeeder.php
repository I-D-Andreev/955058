<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Joe Bloggs';
        $user->email ='joe_blogs_678112@randomemailservice.com';
        $user->email_verified_at = now();
        $user->password = 'A456123AA@';
        $user->remember_token = 'random1234';
        $user->api_token = Str::random(60);
        $user->type="user";
        $user->save();
        
        
        // factory(App\User::class, 5)->create();
        // Users are created at time of Profile creation.
    }
}
