<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
     protected $fillable = [
        'name',
        'abilities',
        'description'
    ];
    protected function casts(): array
    {
        return [
            'abilities' => 'array',
        ];
    }
}