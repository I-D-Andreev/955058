<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    static $count=2;
    return [
        'title'=> ($faker->randomElement(["Empty Title", "No title", "Hello World"])." ".$count++),
        'text'=> $faker->text(250),
        'user_id'=>$faker->numberBetween(1, App\User::count()),
    ];
});
