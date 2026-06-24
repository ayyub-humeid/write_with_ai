<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate();
        return view('admin.roles.index', compact('roles')); // was missing compact('roles')
    }

    public function create()
    {
        $permissions = config('abilities');
        return view('admin.roles.create', ['permissions' => $permissions, 'role' => new Role()]);
        // removed the dd() you had here
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|min:3|unique:roles,name',
            'description' => 'nullable|min:10',
            'abilities'   => 'required|array',
        ]);

        Role::create([
            'name'        => $request->name,
            'description' => $request->description,
            'abilities'   => $request->abilities,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
        // was missing the role variable being passed — already correct actually, just keep it
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'        => 'required|min:3|unique:roles,name,' . $role->id,
            'description' => 'nullable|min:10',
            'abilities'   => 'required|array',
        ]);

        $role->update([
            'name'        => $request->name,
            'description' => $request->description,
            'abilities'   => $request->abilities,
        ]);

        return redirect()->route('admin.roles.show', $role)->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $deleted = $role->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Error while deleting the role.');
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
