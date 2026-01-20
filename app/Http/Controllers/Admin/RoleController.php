<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])->latest()->paginate(20);
        $totalPermissions = Permission::count();
        $usersCount = User::count();
        $systemRoles = Role::whereIn('name', ['admin', 'super-admin'])->count();

        return view('admin.roles.index', compact('roles', 'totalPermissions', 'usersCount', 'systemRoles'));
    }

    public function create()
    {
        try {
            $permissions = Permission::orderBy('name')->get();

            // Skip grouping for now
            return view('admin.roles.create', compact('permissions'));
        } catch (\Exception $e) {
            Log::error('RoleController create error: ' . $e->getMessage());
            return redirect()->route('admin.roles.index')
                ->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name'
            ]);

            $role = Role::create(['name' => $request->name]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            Log::error('RoleController store error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating role: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified role
     */
    public function show(Role $role)
    {
        try {
            $role->load(['users', 'permissions']);
            $allPermissions = Permission::orderBy('name')
                ->get()
                ->groupBy(function ($permission) {
                    return explode('.', $permission->name)[0] ?? 'general';
                });

            return view('admin.roles.show', compact('role', 'allPermissions'));
        } catch (\Exception $e) {
            Log::error('RoleController show error: ' . $e->getMessage());
            return redirect()->route('admin.roles.index')
                ->with('error', 'Error loading role: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified role
     */
    public function edit(Role $role)
    {
        try {
            // Get permissions without grouping
            $permissions = Permission::orderBy('name')->get();

            // Get role's current permission IDs
            $rolePermissionIds = $role->permissions->pluck('id')->toArray();

            return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
        } catch (\Exception $e) {
            Log::error('RoleController edit error: ' . $e->getMessage());
            return redirect()->route('admin.roles.index')
                ->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role)
    {
        try {
            // Prevent modification of system roles
            if (in_array($role->name, ['admin', 'super-admin'])) {
                $request->merge([
                    'name' => $role->name,
                    'guard_name' => $role->guard_name
                ]);
            }

            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'guard_name' => 'required|string|in:web,api,sanctum',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id'
            ]);

            // Update role
            $role->update($request->only('name', 'guard_name'));

            // Sync permissions (use empty array if no permissions selected)
            $permissions = $request->permissions ?? [];
            $role->syncPermissions($permissions);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            Log::error('RoleController update error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error updating role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role)
    {
        try {
            // Prevent deleting super_admin role
            if ($role->name === 'super_admin') {
                return redirect()->route('admin.roles.index')
                    ->with('error', 'Super admin role cannot be deleted.');
            }

            // Prevent deleting roles that have users assigned
            if ($role->users()->count() > 0) {
                return redirect()->route('admin.roles.index')
                    ->with('error', 'Cannot delete role that has users assigned. Reassign users first.');
            }

            $role->delete();

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error('RoleController destroy error: ' . $e->getMessage());
            return redirect()->route('admin.roles.index')
                ->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }

    /**
     * Show role permissions
     */
    public function permissions(Role $role)
    {
        try {
            $permissions = Permission::orderBy('name')
                ->get()
                ->groupBy(function ($permission) {
                    return explode('.', $permission->name)[0] ?? 'general';
                });

            $rolePermissions = $role->permissions->pluck('name')->toArray();

            return view('admin.roles.permissions', compact('role', 'permissions', 'rolePermissions'));
        } catch (\Exception $e) {
            Log::error('RoleController permissions error: ' . $e->getMessage());
            return redirect()->route('admin.roles.index')
                ->with('error', 'Error loading permissions: ' . $e->getMessage());
        }
    }

    /**
     * Sync role permissions
     */
    public function syncPermissions(Request $request, Role $role)
    {
        try {
            $request->validate([
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name'
            ]);

            // Prevent modifying super_admin role permissions
            if ($role->name === 'super_admin') {
                return redirect()->route('admin.roles.index')
                    ->with('error', 'Super admin role permissions cannot be modified.');
            }

            $role->syncPermissions($request->permissions ?? []);

            return redirect()->route('admin.roles.show', $role)
                ->with('success', 'Role permissions updated successfully!');
        } catch (\Exception $e) {
            Log::error('RoleController syncPermissions error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating permissions: ' . $e->getMessage());
        }
    }
}
