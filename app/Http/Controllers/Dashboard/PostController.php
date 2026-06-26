<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\SyncPostTags;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{
// use AuthorizesRequests;
    public function __construct(protected \App\Services\PostService $postService)
    {
        // $this->authorizeResource(Post::class, 'post');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $status = $request->query('status', 'published');

        $posts = Post::where('status', $status)

        ->with('category:id,name','tags:id,name,slug')
        ->withCount('comments')
        ->latest()
        ->paginate(12)->withQueryString();
        $status_options = Post::statusOptions();

         if ($request->ajax()) {
             return response()->json([
                 'html' => view('components.dashboard.posts.post-component', compact('posts'))->render(),
                 'status' => $status,
                 'counts' => [
                     'published' => Post::where('status', 'published')->count(),
                     'draft' => Post::where('status', 'draft')->count(),
                     'archived' => Post::where('status', 'archived')->count(),
                 ]
             ]);
         }
         return view('dashboard.posts.index', compact('posts','status_options','status'));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $post = new Post();
        $categories = Category::select("name","id")->get();
        return view('dashboard.posts.create',compact('post','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        try {
            $this->postService->create($request->all());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create post: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $post = Post::findOrFail($id);
            $post->increment('views');
            $post->load('category:id,name', 'user:id,name', 'tags:id,name,slug');
             $post->loadCount('comments');
             $post->comments()->with('user:id,name')->latest()->get();
             // dd($post->toArray());
            // dd($post);
            return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Return post comments as JSON for dashboard modal.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::select("name","id")->get();
        $post->load('tags:id,name');
        return view('dashboard.posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        
        try {
            $this->postService->update($post, $request->all());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update post: ' . $e->getMessage()]);
        }

        return redirect()->route('dashboard.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $this->postService->delete($post);
        return response()->json(['message' => 'Post deleted successfully.'], 200);
    }
}
