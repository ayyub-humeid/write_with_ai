<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

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

}
