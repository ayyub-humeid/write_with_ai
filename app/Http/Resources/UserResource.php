<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class UserResource extends JsonApiResource
{
    /**
     * The resource's attributes.
     */
    public $attributes = [
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    /**
     * The resource's relationships.
     */
    // public $relationships = [
    //     'posts'=> 
    // ];    
public function toRelationships(Request $request): array
{
    return [
        'posts'=> PostResource::collection($this->whenLoaded('posts')),
    ];
}
}