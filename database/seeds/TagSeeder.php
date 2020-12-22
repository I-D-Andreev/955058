<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = new Tag;
        $tag->name = "hello";
        $tag->save();
        $tag->posts()->attach(1);
        
        // Some tags are also created during Post creation
        factory(App\Tag::class, 10)->create();
        
        $posts = App\Post::get();


        Tag::get()->each(function($tag) use ($posts){
            $tag->posts()->attach(
                $posts->random(rand(1, intdiv(App\Post::count(),3)))->pluck('id')->toArray()
            );
        });
    }
}
