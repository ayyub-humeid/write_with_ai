<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $status = $request->query('status', 'published');
        $posts = Post::where('status', $status)->latest()->paginate(12)->withQueryString();
        $status_options = array_map(function ($item) {
             return [
                 'name'  => ucfirst($item),
                 'count' => Post::where('status', $item)->count() ];
         }, ['published', 'draft', 'archived']);

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
        $data = $request->safe()->except('cover_image');
        
        $data['user_id'] = 1; // TO DO: Use auth()->id() when ready
        $data['slug'] = Str::slug($request->title);
        
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = fileUpload($request->file('cover_image'), 'posts');
        }

        Post::create($data);
        return redirect()->route('dashboard.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $post = Post::findOrFail($id);
            return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::select("name","id")->get();
        return view('dashboard.posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->safe()->except('cover_image');
        $data['slug'] = Str::slug($request->title);

        if ($request->boolean('remove_cover_image')) {
            removeFile($post->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            removeFile($post->cover_image);
            $data['cover_image'] = fileUpload($request->file('cover_image'), 'posts');
        }

        $post->update($data);
        return redirect()->route('dashboard.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);
        // return redirect()->route('dashboard.posts.index')->with('success', 'Post deleted successfully.');
        return response()->json(['message' => 'Post deleted successfully.'], 200);
        }
}
