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
        $comment->commentable_id = 1;
        $comment->commentable_type = App\Post::class;

        $comment->user_id = 1;
        $comment->save();

        // Generate comments in a loop as Comment::count() is not 
        // dynamically incremented in the factory (i.e. is always 1).
        // This way Comment::count() will be incremented after every execution of the loop.
        $totalComments = 300;
        $loops = 50;
        for($i=0; $i<$loops; $i++){
            factory(App\Comment::class, intdiv($totalComments, $loops))->create();
        }
    }
}
