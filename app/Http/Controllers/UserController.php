<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile($username){
        return view('app.profiles.index',['profile'=>User::query()->where('username',$username)->firstOrFail()]);
    }
}