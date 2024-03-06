<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;
    protected $title,$message,$product_id,$user_id,$comment_id;
    /**
     * Create a new notification instance.
     */
    public function __construct($title,$message,$productId,$userId,$commentId)
    {
            $this->title = $title;
            $this->message = $message;
            $this->product_id = $productId;
            $this->user_id = $userId;
            $this->comment_id = $commentId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
           "title" => $this->title,
           'message'=> $this->message,
           'product_id'=> $this->product_id,
           'user_id' => $this->user_id,
           'comment_id'=> $this->comment_id,
        ];
    }
}
