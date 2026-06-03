<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // private $posts=[];

    public function index()
    {
        $posts = Post::paginate(20) ;
        return view('app.posts.index',compact('posts'));
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        // dd($post);
        $post->increment('views');
        $post->save();
        $post->load('user');
        return view('app.posts.show', compact('post'));
    }
}
