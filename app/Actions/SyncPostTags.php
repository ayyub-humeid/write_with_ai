<?php
namespace App\Actions;

use App\Models\Post;
use Str;

class SyncPostTags {
    public function handle(Post $post, string|array $tags):void{
            $tags = is_string($tags) ? explode(',', $tags) : $tags;
             if (empty($tags)) {
            $post->tags()->detach();
            return;
        }
         $tags_ids = [];
         foreach ($tags as $tag) {
             $tag = trim($tag);
             if (empty($tag)) {
                 continue;
             }
             $tagModel = \App\Models\Tag::firstOrCreate(['name' => $tag], ['slug' => \Illuminate\Support\Str::slug($tag)]);
             $tags_ids[] = $tagModel->id;
         }
         $post->tags()->sync($tags_ids);
    }
}
