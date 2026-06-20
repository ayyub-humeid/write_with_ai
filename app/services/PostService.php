<?php

namespace App\Services;

use App\Models\Post;
use App\Actions\SyncPostTags;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class PostService
{
    public function __construct(protected SyncPostTags $syncPostTags)
    {
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return Post
     * @throws \Exception
     */
    public function create(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            // $data['user_id'] = Auth::id();
            // $data['slug'] = Str::slug($data['title']); this already exists in observer
            // 
            $data['content'] = Purifier::clean($data['content'], 'post_content');

            if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
                
                $data['cover_image'] = fileUpload($data['cover_image'], 'posts');
            }
            

            $post = Post::create($data);
            
             if (isset($data['tags'])) {
                $this->syncPostTags->handle($post, $data['tags']);
            }

           

            return $post;
        });
    }

    /**
     * Update an existing post.
     *
     * @param Post $post
     * @param array $data
     * @return Post
     * @throws \Exception
     */
    public function update(Post $post, array $data): Post
    {
        return DB::transaction(function () use ($post, $data) {
            if (isset($data['title'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            if (isset($data['content'])) {
                $data['content'] = Purifier::clean($data['content'], 'post_content');
            }

            if (isset($data['remove_cover_image']) && $data['remove_cover_image']) {
                removeFile($post->cover_image);
                $data['cover_image'] = null;
            }

            if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
                removeFile($post->cover_image);
                $data['cover_image'] = fileUpload($data['cover_image'], 'posts');
            }

            $post->update($data);

            if (isset($data['tags'])) {
                $this->syncPostTags->handle($post, $data['tags']);
            }

            return $post;
        });
    }

    /**
     * Delete a post.
     *
     * @param Post $post
     * @return bool
     */
    public function delete(Post $post): bool
    {
        removeFile($post->cover_image);
        return $post->delete();
    }
}