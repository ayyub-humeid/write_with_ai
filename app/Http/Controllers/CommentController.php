<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Notifications\CommentNotification;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        
        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => $request->content,
            'user_name' => $user->name,
        ]);

        if ($post->user_id !== $user->id) {
            $author = $post->user;
            $author->notify(new CommentNotification($post, $user, $comment));
        }

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user_name' => $comment->user_name,
                'created_at' => $comment->created_at->diffForHumans(),
            ],
            'message' => 'Comment added'
        ]);
    }
}
