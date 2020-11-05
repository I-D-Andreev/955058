<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comment = new Comment;
        $comment->text = "That's a cool post!";
        $comment->save();

        factory(App\Comment::class, 5)->create();
    }
}
