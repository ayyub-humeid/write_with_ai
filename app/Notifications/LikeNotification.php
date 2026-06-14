<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LikeNotification extends Notification
{
    use Queueable;

    public function __construct(protected \App\Models\Post $post, protected \App\Models\User $user)
    {
        //
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

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => "{$this->user->name} liked your post",
            'body' => "{$this->user->name} liked your post: {$this->post->title}",
            'link' => route('posts.show', $this->post->slug),
            'meta' => [
                'post_id' => $this->post->id,
                'user_id' => $this->user->id,
                'user_avatar' => $this->user->avatar,
            ],
        ];
    }
}
