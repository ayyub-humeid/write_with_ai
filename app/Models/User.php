<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Appends(['gravatar_url'])]
class User extends Authenticatable
{
    
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable , HasApiTokens ;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'timezone',
        'status',
        'avatar',
        'bio',
        'location',
        'type',
        'role_id',
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    // protected $appends = [
    //     'gravatar_url'
    // ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getGravatarUrlAttribute(): string
    {
    return $this->avatar? asset('storage/' . $this->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=200&d=identicon';
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function followers() // people who follow this user
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }
    public function followings() // people this user follows
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function hasAppility(string $ability):bool{
        return in_array($ability,$this->role?->abilities);
    }

}
