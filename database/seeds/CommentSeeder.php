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
        $comment->post_id = 1;
        $comment->user_id = 1;
        $comment->save();

        factory(App\Comment::class, 300)->create();
    }
}
