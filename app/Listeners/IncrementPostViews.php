<?php

namespace App\Listeners;

use App\Events\PostViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncrementPostViews
{
    /**
     * Create the event listener.
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Handle the event.
     */
    public function handle(PostViewed $event): void
    {
        $event->post->increment('views');
    }
}
