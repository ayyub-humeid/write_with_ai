<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(protected PostService $postService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()
        ->with(['category:id,name','tags:id,name,slug','likes' ,'comments','user:id,name,username'])
        ->withCount(['likes','comments'])
        ->paginate();
            return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\PostFormRequest $request)
    {
        try{
            $this->postService->create($request->validated());
            return response()->json([
                'message' => 'Post created successfully.',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to create post: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('category:id,name','tags:id,name,slug','likes' ,'comments','user:id,name,username');
        $post->loadCount('comments','likes');
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\PostFormRequest $request, Post $post)
    {
        try{
            $this->postService->update($post,$request->validated());
            return response()->json([
                'message' => 'Post updated successfully.',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to update post: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try{
            $this->postService->delete($post);
            return response()->json([
                'message' => 'Post deleted successfully.',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to delete post: ' . $e->getMessage(),
            ], 500);
        }
    }
}
