<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'text'=> $faker->text(100),
        'post_id'=>$faker->numberBetween(1, App\Post::count()),
        'user_id'=>$faker->numberBetween(1, App\User::count()),
    ];
});
