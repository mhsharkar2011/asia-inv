<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin\Branch;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    /**
     * Display the user edit form.
     */
    public function edit(User $user): View
    {
        // Get all roles and permissions for the form
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        // Group permissions by their prefix (optional, for better organization)
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name);
            $group = $parts[0] ?? 'other';
            $groupedPermissions[$group][] = $permission;
        }

        // Get user's current roles and permissions
        $userRoles = $user->roles->pluck('name')->toArray();
        $userPermissions = $user->getDirectPermissions()->pluck('name')->toArray();

        // Get companies and branches for dropdowns
        $companies = Company::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();

        // Check if user has any companies/branches assigned for preselection
        $assignedCompany = $user->company_id;
        $assignedBranch = $user->id;

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $groupedPermissions,
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions,
            'companies' => $companies,
            'branches' => $branches,
            'assignedCompany' => $assignedCompany,
            'assignedBranch' => $assignedBranch,
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        try {
            // Update basic user information
            $user->fill($request->validated());

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::delete('public/' . $user->avatar);
                }

                // Store new avatar
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
            }

            // Handle avatar removal
            if ($request->has('remove_avatar') && $request->remove_avatar == '1') {
                if ($user->avatar) {
                    Storage::delete('public/' . $user->avatar);
                }
                $user->avatar = null;
            }

            // Handle email verification
            if ($request->has('verify_email') && $request->verify_email == '1') {
                $user->email_verified_at = now();
            }

            // Handle password update if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Update company and branch assignments
            if ($request->has('company_id')) {
                $user->company_id = $request->company_id ?: null;
            }

            if ($request->has('id')) {
                $user->id = $request->id ?: null;
            }

            // Update account status
            if ($request->has('is_active')) {
                $user->is_active = $request->boolean('is_active');
            }

            $user->save();

            // Sync roles if provided
            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            // Sync direct permissions if provided
            if ($request->has('permissions')) {
                $user->syncPermissions($request->permissions);
            } else {
                // If no permissions are selected, remove all direct permissions
                $user->syncPermissions([]);
            }

            // Log the update
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'changes' => $user->getChanges(),
                    'old_values' => $user->getOriginal(),
                    'new_roles' => $request->roles ?? [],
                    'new_permissions' => $request->permissions ?? []
                ])
                ->log('updated user profile');

            return redirect()->route('admin.users.edit', $user)
                ->with('success', 'User profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

     public function show(User $user): View
    {
        // Load user with relationships
        $user->load(['company', 'branch', 'roles', 'permissions']);

        return view('profile.show', compact('user'));
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
