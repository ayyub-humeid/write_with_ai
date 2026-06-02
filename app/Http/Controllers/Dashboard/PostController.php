<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\SyncPostTags;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $status = $request->query('status', 'published');

        $posts = Post::where('status', $status)->where('user_id', Auth::id())

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
                     'published' => Post::where('status', 'published')->where('user_id', Auth::id())->count(),
                     'draft' => Post::where('status', 'draft')->where('user_id', Auth::id())->count(),
                     'archived' => Post::where('status', 'archived')->where('user_id', Auth::id())->count(),
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
    public function store(PostFormRequest $request, SyncPostTags $syncPostTags)
    {
        $data = $request->safe()->except('cover_image');

        $data['user_id'] = Auth::id(); // TO DO: Use auth()->id() when ready
        $data['slug'] = Str::slug($request->title);
        DB::beginTransaction();
         try {

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = fileUpload($request->file('cover_image'), 'posts');
        }

        $post = Post::create($data);
        $syncPostTags->handle($post, $request->tags ?? []);
        DB::commit();
         } catch (\Exception $e) {
             DB::rollBack();
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
    public function update(PostFormRequest $request, string $id, SyncPostTags $syncPostTags)
    {
        $post = Post::findOrFail($id);
        $data = $request->safe()->except('cover_image');
        $data['slug'] = Str::slug($request->title);
            try {
                DB::transaction(function () use ($request, $post, $data, $syncPostTags) {

        if ($request->boolean('remove_cover_image')) {
            removeFile($post->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            removeFile($post->cover_image);
            $data['cover_image'] = fileUpload($request->file('cover_image'), 'posts');
        }

        $post->update($data);
        $syncPostTags->handle($post, $request->tags ?? []);
                }
                );
            }catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update post: ' . $e->getMessage()]);
            }
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

        public function comments(Post $post)
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

        ]);
    }
}