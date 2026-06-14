<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile($username)
    {
        $profile = User::query()
            ->where('username', $username)
            ->withCount(['followers', 'followings', 'posts'])
            ->firstOrFail();

        $posts = $profile->posts()
            ->with(['category', 'user'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(12);

        return view('app.profiles.index', compact('profile', 'posts'));
    }
}