<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Notifications\LikeNotification;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $user = auth()->user();
        $like = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();

        if ($like) {
            $like->delete();
            return response()->json([
                'liked' => false,
                'likes_count' => $post->likes()->count(),
                'message' => 'Unliked'
            ]);
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        if ($post->user_id !== $user->id) {
            $post->user->notify(new LikeNotification($post, $user));
        }

        return response()->json([
            'liked' => true,
            'likes_count' => $post->likes()->count(),
            'message' => 'Liked'
        ]);
    }
}
