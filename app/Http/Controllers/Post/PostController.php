<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // private $posts=[];

    public function index()
    {
        $posts = Post::query()
        ->latest()
        ->with('user:id,name', 'category:id,name')
         ->withCount('comments')
         ->
        paginate(20) ;
        return view('app.posts.index',compact('posts'));
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        event(new \App\Events\PostViewed($post));
        $post->load('user:id,name', 'category:id,name');
        $post->loadCount('comments');
        return view('app.posts.show', compact('post'));
    }
        public function getComments(Post $post)
    {
        if ((int) $post->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $comments = $post->comments()
            ->with('user:id,name')
            ->whereNull('parent_id')
            ->latest()
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'author' => $comment->user?->name ?? $comment->user_name ?? 'Anonymous',
                    'content' => $comment->content,
                    'created_at_human' => $comment->created_at?->diffForHumans(),
                    'created_at' => $comment->created_at?->toDateTimeString(),
                ];
            });

        return response()->json([
            'post_id' => $post->id,
            'comments_count' => $comments->count(),
            'comments' => $comments,
            'status' => 'success',

        ],200);
    }
}