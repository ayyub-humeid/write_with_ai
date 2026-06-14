<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    public function __construct(public \App\Models\Post $post, public \App\Models\User $user, public \App\Models\Comment $comment)
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
            'title' => "{$this->user->name} commented on your post",
            'body' => "{$this->user->name} said: " . \Illuminate\Support\Str::limit($this->comment->content, 50),
            'link' => route('posts.show', $this->post->slug) . "#comment-{$this->comment->id}",
            'meta' => [
                'post_id' => $this->post->id,
                'user_id' => $this->user->id,
                'comment_id' => $this->comment->id,
                'user_avatar' => $this->user->avatar,
            ],
        ];
    }
}
