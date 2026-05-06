<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $posts=[];
    public function __construct(){
        $this->posts = include(app_path('services/posts.php'));
    }
    public function index()
    {
        $posts = $this->posts;
        return view('app.posts.index',compact('posts'));
    }
    public function show($post)
    {
        $post = collect($this->posts)->where('slug',$post)->first();
        // dd($post);


        return view('app.posts.show', compact('post'));
    }
}