<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
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
