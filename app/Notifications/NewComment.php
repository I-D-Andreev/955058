<?php

namespace App\Notifications;

use App\Comment;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    private $MAX_NOTIFICATION_LENGTH = 35;

    public Comment $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
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
        $post = $this->comment->commentable;
        $title = 'New comment in '.$post->title.'!';
        return [
            'title' => $this->reduceString($title),
            'text' => $this->reduceString($this->comment->text),
            'commenter' => $this->reduceString($this->comment->author->name),
            'postId' => $post->id,
        ];
    }
    
    private function reduceString($text){
        return (strlen($text) < $this->MAX_NOTIFICATION_LENGTH) ? 
            $text: 
            substr($text, 0, $this->MAX_NOTIFICATION_LENGTH).'...';
    }
   
}
