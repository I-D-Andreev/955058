<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'=> $faker->randomElement(["Empty Title", "No title", "Hello World"]),
        'text'=> $faker->text(250),
        'author_id'=>$faker->numberBetween(1, App\User::count()),
    ];
});
