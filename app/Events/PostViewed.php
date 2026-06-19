<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostViewed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Post $post)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('posts.' . $this->post->user_id),
        ];
    }
    public function broadcastWith(): array
    {
      
        // load the post with its relations
        $this->post->load('user', 'likes', 'comments');
        return [
            'post' => $this->post,
        ];
        //  we use broadcastWith to send the post with its relations to the frontend
        //  this is because the post is lazy loaded by default
        // thats mean if we dont use broadcastWith the frontend will not receive the post with its relations
        // and we will get an error in the frontend
        // so it something like passing data to the frontend to display it
        
    }
    public function broadcastAs(): string
    {
        return 'post-viewed';
    }
}
