<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

  
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
    ];
    protected $hidden = [
        'password', 
        'remember_token'
    ];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function getGravatarUrlAttribute(): string
    {
       $baseUrl = 'https://ui-avatars.com/api/';
    $params = http_build_query([
        'name' => $this->name,
        'background' => 'random',
        'color' => 'fff',
        'size' => '128',
        'length' => '1',
        'bold' => 'true',
        'uppercase' => 'true',
        'font-size' => '0.45'
    ]);

    $default = $baseUrl . '?' . $params;

    $hash = md5(strtolower(trim($this->email)));

    return "https://www.gravatar.com/avatar/$hash?s=128&d=" . urlencode($default);
    }
}
