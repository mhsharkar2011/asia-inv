<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')->latest()->paginate(20);
        $roles = Role::withCount('permissions')->get();

        return view('admin.users.permissions.index', compact('permissions', 'roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|in:web,api,sanctum',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        try {
            $permission = Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name
            ]);

            if ($request->has('roles')) {
                $permission->roles()->sync($request->roles);
            }

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create permission: ' . $e->getMessage());
        }
    }
    public function edit(Permission $permission, $userId)
    {
        $roles = Role::withCount('permissions')->get();
        $user = User::with('permissions')->findOrFail($userId);
        $permissions = Permission::all();

        return view('admin.permissions.edit', compact('permission', 'permissions', 'user', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'guard_name' => 'required|string|in:web,api,sanctum',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $permission->update($request->only('name', 'guard_name'));
        $permission->roles()->sync($request->roles ?? []);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
