<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $acc;
    public $post;
    public $comment;

    public function __construct($acc , $post , $comment)
    {
        $this->acc = $acc;
        $this->post = $post;
        $this->comment = $comment;
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
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'id' => $this->acc->id,
            'name' => $this->acc->name,
            'post_id' => $this->post->id,
            'message' => "{$this->acc->name} commented '{$this->comment}'"
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}