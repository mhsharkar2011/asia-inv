<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\Organization;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            // Start with basic query
            $query = User::query();

            // Search
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            }

            // Role filter - simplified
            if ($request->filled('role')) {
                $role = $request->input('role');
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            }

            // Status filter
            if ($request->filled('status')) {
                $status = $request->input('status');
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            }

            // Company filter
            if ($request->filled('company_id')) {
                $query->where('company_id', $request->input('company_id'));
            }

            // Branch filter
            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->input('branch_id'));
            }

            // Order and paginate
            $users = $query->orderBy('created_at', 'desc')->paginate(10);

            // Statistics - simplified
            $totalUsers = User::count();
            $activeUsers = User::where('is_active', true)->count();
            $activeUsersPercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 2) : 0;

            // Count admin users using Spatie
            $adminUsers = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['admin', 'super_admin']);
            })->count();

            $adminPercentage = $totalUsers > 0 ? round(($adminUsers / $totalUsers) * 100, 2) : 0;

            // Today's logins
            $todayLogins = User::whereNotNull('last_login_at')
                ->whereDate('last_login_at', today())
                ->count();

            // Recent activity
            $recentActivity = User::where('created_at', '>=', now()->subDay())
                ->orWhere('updated_at', '>=', now()->subDay())
                ->count();

            // Get data for filters
            $companies = Organization::where('type', 'company')->get(['id', 'name']);
            $branches = Branch::all(['id', 'name']);

            // Get roles
            $roles = [];
            if (class_exists(Role::class)) {
                try {
                    $roles = Role::pluck('name', 'name')->toArray();
                } catch (\Exception $e) {
                    Log::error('Failed to get roles: ' . $e->getMessage());
                    // Fallback to basic roles
                    $roles = [
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                        'manager' => 'Manager',
                        'staff' => 'Staff',
                        'user' => 'User',
                        'customer' => 'Customer'
                    ];
                }
            }

            return view('admin.users.index', compact(
                'users',
                'totalUsers',
                'activeUsers',
                'activeUsersPercentage',
                'adminUsers',
                'adminPercentage',
                'todayLogins',
                'recentActivity',
                'companies',
                'branches',
                'roles'
            ));
        } catch (\Exception $e) {
            Log::error('UserController index error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return redirect()->route('admin.dashboard')
                ->with('error', 'Error loading users: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $companies = Organization::where('type', 'company')->get(['id', 'name']);
            $branches = Branch::all(['id', 'name']);

            // Get roles
            $roles = [];
            if (class_exists(Role::class)) {
                $roles = Role::pluck('name', 'name')->toArray();
            } else {
                $roles = [
                    'super_admin' => 'Super Admin',
                    'admin' => 'Admin',
                    'manager' => 'Manager',
                    'staff' => 'Staff',
                    'user' => 'User',
                    'customer' => 'Customer'
                ];
            }

            return view('admin.users.create', compact('branches', 'roles', 'companies'));
        } catch (\Exception $e) {
            Log::error('UserController create error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validationRules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'username' => 'nullable|string|max:255|unique:users,username',
                'phone' => 'nullable|string|max:20',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'company_id' => 'nullable|exists:organizations,id',
                'branch_id' => 'nullable|exists:branches,id',
                'address' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'language_preference' => 'nullable|in:en,es,fr,de,zh',
                'is_active' => 'boolean',
            ];

            // Add roles validation if using Spatie
            if (class_exists(Role::class)) {
                $validationRules['roles'] = 'required|array';
                $validationRules['roles.*'] = 'exists:roles,name';
            } else {
                // Fallback for legacy role system
                $validationRules['role'] = 'required|in:super_admin,admin,manager,staff,user,customer';
            }

            $request->validate($validationRules);

            // Handle avatar upload
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username ?? $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'company_id' => $request->company_id,
                'branch_id' => $request->branch_id,
                'address' => $request->address,
                'avatar' => $avatarPath,
                'language_preference' => $request->language_preference ?? 'en',
                'is_active' => $request->boolean('is_active', true),
                'email_verified_at' => now(),
                'created_by' => Auth::id(),
            ];

            $user = User::create($userData);

            // Assign roles or set legacy role
            if (class_exists(Role::class) && $request->has('roles')) {
                $user->syncRoles($request->roles);
            } elseif ($request->has('role')) {
                // Legacy role assignment
                $user->update(['role' => $request->role]);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('UserController store error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(User $user)
    {
        try {
            // Load relationships
            $user->load(['branch', 'company', 'roles']);

            return view('admin.users.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('UserController show error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error loading user details: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        try {
            $companies = Organization::where('type', 'company')->get(['id', 'name']);
            $branches = Branch::all(['id', 'name']);

            // Get roles
            $roles = [];
            $userRoles = [];

            if (class_exists(Role::class)) {
                $roles = Role::pluck('name', 'name')->toArray();
                $userRoles = $user->roles->pluck('name')->toArray();
            } else {
                $roles = [
                    'super_admin' => 'Super Admin',
                    'admin' => 'Admin',
                    'manager' => 'Manager',
                    'staff' => 'Staff',
                    'user' => 'User',
                    'customer' => 'Customer'
                ];
                $userRoles = [$user->role];
            }

            return view('admin.users.edit', compact('user', 'branches', 'roles', 'companies', 'userRoles'));
        } catch (\Exception $e) {
            Log::error('UserController edit error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            // Base validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'branch_id' => 'nullable|exists:branches,id',
                'company_id' => 'nullable|exists:organizations,id',
                'address' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'password' => 'nullable|string|min:8|confirmed',
                'is_active' => 'boolean',
                'remove_avatar' => 'boolean',
            ];

            // Add roles validation if using Spatie
            if (class_exists(Role::class)) {
                $rules['roles'] = 'required|array';
                $rules['roles.*'] = 'exists:roles,name';
            } else {
                $rules['role'] = 'required|in:super_admin,admin,manager,staff,user,customer';
            }

            $validated = $request->validate($rules);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $avatarPath;
            } elseif ($request->boolean('remove_avatar')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validated['avatar'] = null;
            } else {
                unset($validated['avatar']);
            }

            // Handle password update
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
            }

            // Update user
            $user->update($validated);

            // Handle roles
            if (class_exists(Role::class) && $request->has('roles')) {
                $user->syncRoles($request->roles);
            } elseif ($request->has('role')) {
                $user->update(['role' => $request->role]);
            }

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'User updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('UserController update error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->id === Auth::id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'You cannot delete your own account.');
            }

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('UserController destroy error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        try {
            // Prevent changing status of own account
            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change status of your own account.'
                ], 403);
            }

            // Check permissions
            $this->checkUserStatusChangePermissions($user);

            $newStatus = !$user->is_active;
            $user->update(['is_active' => $newStatus]);

            return response()->json([
                'success' => true,
                'is_active' => $user->is_active,
                'message' => 'User ' . ($newStatus ? 'activated' : 'deactivated') . ' successfully.'
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to change user status.'
            ], 403);
        } catch (\Exception $e) {
            Log::error('UserController toggleStatus error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error changing user status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify user email
     */
    public function verifyEmail(User $user)
    {
        try {
            // Check permissions
            $this->checkUserModificationPermissions($user);

            $user->update(['email_verified_at' => now()]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Email verified successfully.');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You are not authorized to verify email for this user.');
        } catch (\Exception $e) {
            Log::error('UserController verifyEmail error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error verifying email: ' . $e->getMessage());
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        try {
            // Check permissions
            $this->checkUserModificationPermissions($user);

            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => now(),
                'force_password_change' => true,
            ]);

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'Password reset successfully. User will be forced to change password on next login.');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You are not authorized to reset password for this user.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('UserController resetPassword error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error resetting password: ' . $e->getMessage());
        }
    }

    /**
     * Login as another user
     */
    public function loginAs(User $user)
    {
        try {
            // Prevent logging in as yourself
            if ($user->id === Auth::id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'You are already logged in.');
            }

            // Store original user data
            session([
                'original_user_id' => Auth::id(),
                'original_user_name' => Auth::user()->name,
                'impersonating' => true,
                'impersonation_start' => now(),
            ]);

            // Add roles to session if available
            if (method_exists(Auth::user(), 'getRoleNames')) {
                session(['original_user_roles' => Auth::user()->getRoleNames()->toArray()]);
            }

            // Login as the user
            Auth::login($user);

            Log::info('User ' . session('original_user_id') . ' logged in as user ' . $user->id);

            return redirect()->route('dashboard')
                ->with('success', 'Logged in as ' . $user->name . '. You can return to your account via the "Return to Admin" link.');
        } catch (\Exception $e) {
            Log::error('UserController loginAs error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error logging in as user: ' . $e->getMessage());
        }
    }

    /**
     * Export users
     */
    public function export(Request $request)
    {
        try {
            $query = User::query();

            // Search
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            }

            // Role filter
            if ($request->filled('role') && method_exists(User::class, 'roles')) {
                $role = $request->input('role');
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            }

            // Status filter
            if ($request->filled('status')) {
                $status = $request->input('status');
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            }

            $users = $query->orderBy('created_at', 'desc')->get();

            $fileName = 'users-' . date('Y-m-d-H-i-s') . '.csv';

            return response()->streamDownload(function () use ($users) {
                $handle = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fwrite($handle, "\xEF\xBB\xBF");

                // Add headers
                fputcsv($handle, [
                    'ID',
                    'Name',
                    'Username',
                    'Email',
                    'Phone',
                    'Roles',
                    'Company',
                    'Branch',
                    'Status',
                    'Email Verified',
                    'Last Login',
                    'Created At'
                ]);

                // Add data
                foreach ($users as $user) {
                    // Get role names safely
                    $roleNames = '';
                    if (method_exists($user, 'getRoleNames')) {
                        $roleNames = $user->getRoleNames()->implode(', ');
                    }

                    // Get company and branch names safely
                    $companyName = '';
                    if ($user->company && $user->company->name) {
                        $companyName = $user->company->name;
                    }

                    $branchName = '';
                    if ($user->branch && $user->branch->name) {
                        $branchName = $user->branch->name;
                    }

                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->username,
                        $user->email,
                        $user->phone ?? '',
                        $roleNames,
                        $companyName,
                        $branchName,
                        $user->is_active ? 'Active' : 'Inactive',
                        $user->email_verified_at ? 'Yes' : 'No',
                        $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
                        $user->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($handle);
            }, $fileName);
        } catch (\Exception $e) {
            Log::error('UserController export error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error exporting users: ' . $e->getMessage());
        }
    }

    /**
     * Assign permissions to user
     */
    public function assignPermissions(Request $request, User $user)
    {
        try {
            if (!method_exists($user, 'syncPermissions')) {
                return redirect()->route('admin.users.show', $user)
                    ->with('error', 'Permission system not available.');
            }

            $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ]);

            $user->syncPermissions($request->permissions);

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'Permissions assigned successfully.');
        } catch (\Exception $e) {
            Log::error('UserController assignPermissions error: ' . $e->getMessage());
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'Error assigning permissions: ' . $e->getMessage());
        }
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:activate,deactivate,delete',
                'users' => 'required|array',
                'users.*' => 'exists:users,id',
            ]);

            $users = User::whereIn('id', $request->users)->get();
            $action = $request->action;

            $processed = 0;
            $skipped = 0;

            foreach ($users as $user) {
                // Skip if trying to modify own account
                if ($user->id === Auth::id() && in_array($action, ['deactivate', 'delete'])) {
                    $skipped++;
                    continue;
                }

                try {
                    // Check permissions
                    if ($action === 'delete') {
                        $this->checkUserDeletionPermissions($user);
                    } else {
                        $this->checkUserModificationPermissions($user);
                    }

                    switch ($action) {
                        case 'activate':
                            $user->update(['is_active' => true]);
                            break;
                        case 'deactivate':
                            $user->update(['is_active' => false]);
                            break;
                        case 'delete':
                            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                                Storage::disk('public')->delete($user->avatar);
                            }
                            $user->delete();
                            break;
                    }

                    $processed++;
                } catch (\Exception $e) {
                    $skipped++;
                    Log::warning('Bulk action skipped for user ' . $user->id . ': ' . $e->getMessage());
                }
            }

            $message = "Bulk action completed. {$processed} users processed.";
            if ($skipped > 0) {
                $message .= " {$skipped} users skipped.";
            }

            return redirect()->route('admin.users.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('UserController bulkAction error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error performing bulk action: ' . $e->getMessage());
        }
    }

    /**
     * Check if current user can assign requested roles
     */
    private function checkRoleAssignmentPermissions($requestedRoles, $user = null)
    {
        $currentUser = Auth::user();

        // If no current user or not using roles, allow
        if (!$currentUser || !method_exists($currentUser, 'hasRole')) {
            return true;
        }

        // Super admin can assign any role
        if ($currentUser->hasRole('super_admin')) {
            return true;
        }

        // Get current user's highest role level
        $currentUserRoles = $currentUser->getRoleNames()->toArray();
        $currentUserHighestLevel = $this->getRoleLevel($currentUserRoles);

        // Get requested roles' highest level
        $requestedHighestLevel = $this->getRoleLevel($requestedRoles);

        // Users cannot assign roles higher than their own
        if ($requestedHighestLevel > $currentUserHighestLevel) {
            abort(403, 'You cannot assign roles higher than your own.');
        }

        // Check if trying to modify a user with higher role
        if ($user && $user->hasRole('super_admin') && !$currentUser->hasRole('super_admin')) {
            abort(403, 'Cannot modify super admin.');
        }

        return true;
    }

    /**
     * Check if current user can modify this user
     */
    private function checkUserModificationPermissions($user)
    {
        $currentUser = Auth::user();

        // Users can always modify themselves
        if ($currentUser->id === $user->id) {
            return true;
        }

        // If not using roles, allow admins
        if (!method_exists($currentUser, 'hasRole')) {
            // Basic check - allow if current user is admin
            if ($currentUser->role === 'admin' || $currentUser->role === 'super_admin') {
                return true;
            }
            abort(403, 'Unauthorized access.');
        }

        // Super admin can modify anyone
        if ($currentUser->hasRole('super_admin')) {
            return true;
        }

        // Get current user's highest role level
        $currentUserRoles = $currentUser->getRoleNames()->toArray();
        $currentUserHighestLevel = $this->getRoleLevel($currentUserRoles);

        // Get target user's highest role level
        $targetUserRoles = $user->getRoleNames()->toArray();
        $targetUserHighestLevel = $this->getRoleLevel($targetUserRoles);

        // Users cannot modify users with higher or equal role level
        if ($targetUserHighestLevel >= $currentUserHighestLevel) {
            abort(403, 'You cannot modify users with equal or higher role level.');
        }

        return true;
    }

    /**
     * Check if current user can delete this user
     */
    private function checkUserDeletionPermissions($user)
    {
        $currentUser = Auth::user();

        // If not using roles, basic check
        if (!method_exists($currentUser, 'hasRole')) {
            // Only allow deletion if current user is super admin
            if ($currentUser->role === 'super_admin') {
                return true;
            }
            abort(403, 'Unauthorized access.');
        }

        // Super admin can delete anyone (except themselves, handled elsewhere)
        if ($currentUser->hasRole('super_admin')) {
            return true;
        }

        // Get current user's highest role level
        $currentUserRoles = $currentUser->getRoleNames()->toArray();
        $currentUserHighestLevel = $this->getRoleLevel($currentUserRoles);

        // Get target user's highest role level
        $targetUserRoles = $user->getRoleNames()->toArray();
        $targetUserHighestLevel = $this->getRoleLevel($targetUserRoles);

        // Users cannot delete users with higher or equal role level
        if ($targetUserHighestLevel >= $currentUserHighestLevel) {
            abort(403, 'You cannot delete users with equal or higher role level.');
        }

        return true;
    }

    /**
     * Check if current user can change status of this user
     */
    private function checkUserStatusChangePermissions($user)
    {
        return $this->checkUserModificationPermissions($user);
    }

    /**
     * Get role level for hierarchy checking
     * Lower number = higher privilege
     */
    private function getRoleLevel($roles)
    {
        $roleHierarchy = [
            'super_admin' => 1,
            'admin' => 2,
            'manager' => 3,
            'staff' => 4,
            'customer' => 5,
            'viewer' => 6,
            'user' => 7,
        ];

        $lowestLevel = PHP_INT_MAX;

        foreach ($roles as $role) {
            if (isset($roleHierarchy[$role]) && $roleHierarchy[$role] < $lowestLevel) {
                $lowestLevel = $roleHierarchy[$role];
            }
        }

        return $lowestLevel === PHP_INT_MAX ? 99 : $lowestLevel;
    }
}
