<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification
{
    use Queueable;

    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($m)
    {
        $this->message = $m;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // dd($notifiable);
        return ['broadcast'];
    }
    
    public function toArray($notifiable){
        // dd("toArray");
        // dd($notifiable);
        return ['text' => "hello world1111", 'text2' => 'hiya'];
    }
    
   
}
