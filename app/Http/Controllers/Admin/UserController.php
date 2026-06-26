<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->paginate(10);

        abort_if(!Auth::user()->can('viewAny',User::class), 403);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        abort_if(!Auth::user()->can('update',$user),403);
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        abort_if(!Auth::user()->can('update',$user),403);

        $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'type' => 'required|in:user,admin,super-admin',
        ]);

        $user->update([
            'role_id' => $request->role_id,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }
}
