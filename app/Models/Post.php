<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    protected static function booted()
    {

        static::addGlobalScope(new Scopes\OwnerPostScope);
    }

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
                 'count' => Post::where('status', $item)->count() ];
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
    //  public function content(): Attribute
    // {
    //     return new Attribute(
    //         set: fn($value) => strip_tags($value, '<h2><h3><h4><h5><h6><p><a><ul><ol><li><br><strong><em><img><video><audio>'),
    //     );
    // }

     public function title(): Attribute
    {
        return new Attribute(
            get: fn($value) => ucwords($value),
        );
    }

     public function thumbnailUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->cover_image
                    ? asset('storage/' . $this->cover_image)
                    : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCe9z5-CMxvCeCQThs7kHzXQ5geJGBesnpuQA7xMHfACS22Pxtkz4R7KK9r2bvlMMQw0dcote6RP0On5Tfiu4fPCTiAUZD7FMlSMV5mGUEbKYzWeebVMGq3fVli3vncJYSUj8lHI5od9K87xxH50MrEwLkFtOqVf7isIQFSMFZNyPWjKcLqU9cy4ueAsQnu3Q-sn7a3GaYWe-h3MpWxNwyaLxKSk3xhfxcVEi_H6xbFghZghxTOkCJnEq6APCaOSL0cc2jtB8-DzQ59' ;
            }
        );
    }

}
