<?php

namespace App\Http\Controllers\Post;

use App\Events\PostViewed;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // private $posts=[];

    public function index(Request $request)
    {
        $filter = $request->query('filter','explore');
        $query = Post::query()

        ->with('user:id,name', 'category:id,name')
         ->withCount('comments');
         switch ($filter) {
    case 'recent':
        $query->latest();
        break;

    case 'explore':
        $query->orderByDesc('comments_count')->latest();
        break;

    case 'popular':
        $query->orderByDesc('views');
        break;

    default:
        $query->latest();
        break;
}


       $posts = $query->paginate(20) ;
        // dd($posts);
        return view('app.posts.index',compact('posts'));
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        // event(new \App\Events\PostViewed($post));
        broadcast(new PostViewed($post))->toOthers();

        $post->load('user:id,name', 'category:id,name');
        $post->loadCount(['comments', 'likes']);
        return view('app.posts.show', compact('post'));
    }
        public function getComments(Post $post)
    {

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
