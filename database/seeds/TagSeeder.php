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
        
        factory(App\Tag::class, 10)->create();
        
        $posts = App\Post::get();

        Tag::get()->except(1)->each(function($tag) use ($posts){
            // Attach a random number of posts (1 - PostCount/3) to each tag except the first.
            // Do not attach posts to the first tag so as not to violate the unique
            // constaint (tagId-postId) if we randomly choose to insert 1-1 again (as it is already added manually).
            $tag->posts()->attach(
                $posts->random(rand(1, intdiv(App\Post::count(),3)))->pluck('id')->toArray()
            );
        });
    }
}
