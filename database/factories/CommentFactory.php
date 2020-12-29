<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $commentable = [[App\Post::class, App\Post::count()],
                    [App\Comment::class, App\Comment::count()]];
    $choice = $faker->numberBetween(0, count($commentable)-1);

    return [
        'text'=> $faker->text(100),
        'commentable_type'=> $commentable[$choice][0],
        'commentable_id'=> $faker->numberBetween(1, $commentable[$choice][1]),
        'user_id'=>$faker->numberBetween(1, App\User::count()),
    ];
});
