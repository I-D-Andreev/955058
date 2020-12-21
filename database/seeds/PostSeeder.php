<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new Post;
        $post->title = "How much does a corgi weigh?";
        $post->text = "Did you know? Corgis weigh up to 14 kilograms!
         I am too lazy to write more so this is the end.";
        $post->user_id = 1;
        $post->save();

        factory(App\Post::class, 30)->create();
    }
}
