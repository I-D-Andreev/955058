<?php

namespace App\Notifications;

use App\Comment;
use App\Post;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    private $MAX_NOTIFICATION_LENGTH = 35;

    public Comment $comment;
    public Post $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, Post $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }
    
    public function toArray($notifiable){
        $title = 'New comment in '.$this->post->title.'!';
        return [
            'title' => $this->reduceString($title),
            'text' => $this->reduceString($this->comment->text),
            'commenter' => $this->reduceString($this->comment->author->name),
            'postId' => $this->post->id,
        ];
    }
    
    private function reduceString($text){
        return (strlen($text) < $this->MAX_NOTIFICATION_LENGTH) ? 
            $text: 
            substr($text, 0, $this->MAX_NOTIFICATION_LENGTH).'...';
    }
   
}
