<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return Post::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->postService->create($request->all());
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
        $post->load('category:id,name','tags:id,name,slug','comments');
        $post->loadCount('comments');
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try{
            $this->postService->update($post,$request->all());
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
