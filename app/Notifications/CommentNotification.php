<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;

    public function __construct(public \App\Models\Post $post, public \App\Models\User $user, public \App\Models\Comment $comment)
    {
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
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
    public function toBroadcast(object $notifiable): array|BroadcastMessage
    {
        return new BroadcastMessage([
            'not_type'=> 'comment',
            'title' => "{$this->user->name} commented on your post",
            'body' => "{$this->user->name} said: " . \Str::limit($this->comment->content, 50),
            'link' => route('posts.show', $this->post->slug) . "#comment-{$this->comment->id}",
            'meta' => [
                'post_id' => $this->post->id,
                'user_id' => $this->user->id,
                'comment_id' => $this->comment->id,
                'user_avatar' => $this->user->avatar,
            ],
        ]);
    }
    // without broadcaston it will send to channel (App.U)
    public function broadcastOn(){
        return [new PrivateChannel('notifications.newComment.' . $this->post->user_id)];
    }
}
