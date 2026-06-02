<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    // protected $connection = 'mysql';
    // protected $table = 'posts';
    // protected $primaryKey = 'id';
    // public $incrementing = true;
    // protected $keyType = 'int';
    // public $timestamps = true;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'slug',
        'excerpt',
        'cover_image',
        'status',
        'views',
    ];

    // protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function statusOptions()
    {
        return array_map(function ($item) {
             return [
                 'name'  => ucfirst($item),
                 'count' => Post::where('status', $item)->where('user_id', Auth::id())->count() ];
         }, ['published', 'draft', 'archived']);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
