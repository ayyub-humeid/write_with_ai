<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'content'=>$this->content,
            'excerpt'=>$this->excerpt,
            'cover_image'=>$this->thumbnail_url,
            'status'=>$this->status,
            'views'=>$this->views,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'category'=> $this->whenLoaded('category') ,
            // new CategoryResource($this->whenLoaded('category'))
            'user'=> $this->whenLoaded('user') ,
            // new UserResource($this->whenLoaded('user'))
            'tags'=> $this->whenLoaded('tags') ,
            // TagResource::collection($this->whenLoaded('tags'))
            'comments'=> $this->whenLoaded('comments') ,
            // CommentResource::collection($this->whenLoaded('comments'))
            'likes'=> $this->whenLoaded('likes') ,
            // LikeResource::collection($this->whenLoaded('likes'))
            'comments_count'=>$this->comments_count,
            'likes_count'=>$this->likes_count,
        ];
    }
}
