<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
     public function __construct(protected User $user, protected User $follower)
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
        // return ['mail'];
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
     public function toDatabase(object $notifiable): array
    {
        return [
            'title' => " Hi {$this->user->name} You have New follower",
            'body' => "{$this->follower->name} started following you.",
            'link' => route('users.profile', $this->follower->username),
            'meta' => [
                'follower_id' => $this->follower->id,
                'follower_avatar' => $this->follower->avatar,
            ],
        ];
    }
//this will use channel App.Models.User by deafult
    public function toBroadcast(object $notifiable): array|BroadcastMessage
{
    return new BroadcastMessage([
        'not_type'=>'follow',
        'title' => 'New follower',
        'body' => "{$this->follower->name} started following you.",
        'link' => route('users.profile', $this->follower->username),
        'meta' => [
            'follower_id' => $this->follower->id,
            'follower_avatar' => $this->follower->avatar,
        ],
    ]);
}
// if we don't use broadcastType method , it will take the class name as the event name
// so we need to use broadcastType method to specify the event name

    public function broadcastType(): string
    {
        return 'follow.notification';
        // this will be the event name in the broadcast and
        // use it in the frontend in Echo.private(`App.Models.User.${USER_ID}`)
        // .listen('.follow.notification' ...
    }
    // public function broadcastOn(){
    //     return [new PrivateChannel('App.Models.User.' . $this->user->id)];
    // }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
