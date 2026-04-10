<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Admin\Branch;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use App\Models\AuditLog;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;
use Pest\Support\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view users|view any users', ['only' => ['index', 'show']]);
        $this->middleware('permission:create users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
        $this->middleware('permission:manage permissions', ['only' => ['permissions', 'syncPermissions', 'syncRoles']]);
        $this->middleware('permission:impersonate users', ['only' => ['loginAs']]);
    }

    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        try {
            $query = User::with(['company', 'branch'])
                ->with('roles')
                ->latest();

            // Check if login_logs table exists before adding the count
            if (Schema::hasTable('login_logs')) {
                $query->withCount([
                    'loginLogs as today_logins_count' => function ($query) {
                        $query->whereDate('logged_in_at', today())
                            ->where('status', 'success');
                    }
                ]);
            }

            // Check if activities table exists before adding the count
            if (Schema::hasTable('activities')) {
                $query->withCount([
                    'activities as today_activities_count' => function ($query) {
                        $query->whereDate('created_at', today());
                    }
                ]);
            }

            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // Filter by status
            if ($request->has('status')) {
                $query->where('is_active', $request->status === 'active');
            }

            // Filter by role (using Spatie roles)
            if ($request->has('role') && $request->role !== 'all') {
                $query->role($request->role);
            }

            $users = $query->paginate(20)->withQueryString();

            // Calculate statistics
            $totalUsers = User::count();
            $activeUsers = User::where('is_active', true)->count();
            $adminUsers = User::role('admin')->count();
            $unverifiedUsers = User::whereNull('email_verified_at')->count();

            // Get recent activity count
            $recentActivity = 0;
            if (Schema::hasTable('activities')) {
                $recentActivity = Activity::where('created_at', '>=', now()->subDay())->count();
            }

            // Get today's successful logins
            $todayLogins = 0;
            if (Schema::hasTable('login_logs')) {
                $todayLogins = LoginLog::whereDate('logged_in_at', today())
                    ->where('status', 'success')
                    ->count();
            } else {
                // Fallback to last_login_at field
                $todayLogins = User::whereDate('last_login_at', today())->count();
            }

            // Calculate percentages
            $activeUsersPercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0;
            $adminPercentage = $totalUsers > 0 ? round(($adminUsers / $totalUsers) * 100, 1) : 0;
            $unverifiedPercentage = $totalUsers > 0 ? round(($unverifiedUsers / $totalUsers) * 100, 1) : 0;

            // Get all roles for filter dropdown
            $roles = Role::orderBy('name')->pluck('name', 'name')->toArray();
            // Get companies and branches
            $companies = Company::orderBy('name')->get();
            $branches = Branch::orderBy('name')->get();

            return view('admin.users.index', compact(
                'users',
                'totalUsers',
                'activeUsers',
                'adminUsers',
                'unverifiedUsers',
                'recentActivity',
                'todayLogins',
                'activeUsersPercentage',
                'adminPercentage',
                'unverifiedPercentage',
                'roles',
                'companies',
                'branches'
            ));
        } catch (\Exception $e) {
            Log::error('UserController index error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Error loading users: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        // Get companies and branches
        $companies = Company::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0] ?? 'general';
        });

        return view('admin.users.create', compact('roles', 'companies', 'branches', 'permissions'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        try {
            // Validation rules - ADDED missing fields
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                // 'username' => 'nullable|string|max:255|unique:users,username',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
                'is_active' => 'boolean',
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,name',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name',
                'company_id' => 'nullable|exists:companies,id',
                'branch_id' => 'nullable|exists:branches,id',
                'language_preference' => 'nullable|string|in:en,es,fr,de,zh',
            ];

            $validated = $request->validate($rules);

            // Handle avatar upload
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // Generate username if not provided
            $username = $validated['username'] ?? null;
            if (!$username) {
                $username = explode('@', $validated['email'])[0];
                // Make sure username is unique
                $baseUsername = $username;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }
            }

            // Create user - ADDED missing fields
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                // 'username' => $username,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'password' => Hash::make($validated['password']),
                'avatar' => $avatarPath,
                'is_active' => $request->boolean('is_active', true),
                'company_id' => $validated['company_id'] ?? null,
                'branch_id' => $validated['branch_id'] ?? null,
                'language_preference' => $validated['language_preference'] ?? 'en',
                'email_verified_at' => now(),
                'created_by' => Auth::id()
            ]);

            // Assign roles
            $user->syncRoles($validated['roles']);

            // Assign direct permissions if provided
            if (!empty($validated['permissions'])) {
                $user->syncPermissions($validated['permissions']);
            }

            // Send welcome email if requested
            if ($request->boolean('send_welcome_email')) {
                // Add your welcome email logic here
                // Mail::to($user->email)->send(new WelcomeEmail($user, $request->password));
            }

            // Log activity
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->log('created user');

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully!');
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


    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load('company', 'branch', 'permissions', 'activities', 'loginLogs');

        // Get all permissions grouped by module
        $allPermissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0] ?? 'general';
        });

        return view('admin.users.show', compact('user', 'allPermissions'));
    }

    public function edit(User $user)
    {
        // Prevent editing yourself
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot edit your own profile from here.');
        }

        // Get all roles from Spatie
        $roles = Role::orderBy('name')->get();

        // Get all permissions grouped by module
        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')
            ->get()
            ->groupBy(function ($permission) {
                return explode('.', $permission->name)[0] ?? 'general';
            });

        // Get user's current roles and permissions
        $userRoles = $user->roles->pluck('name')->toArray();
        $userPermissions = $user->permissions->pluck('name')->toArray();

        // Get companies and branches
        $companies = Company::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();

        return view('admin.users.edit', compact(
            'user',
            'roles',
            'permissions',
            'userRoles',
            'userPermissions',
            'companies',
            'branches'
        ));
    }

    public function update(Request $request, User $user)
    {
        try {
            // Prevent editing yourself
            if ($user->id === Auth::id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'You cannot edit your own profile from here.');
            }

            // Validation rules - FIXED branch_id and ADDED missing fields
            $rules = [
                'name' => 'required|string|max:255',
                // 'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
                'remove_avatar' => 'boolean',
                'password' => 'nullable|min:8|confirmed',
                'is_active' => 'boolean',
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,name',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name',
                'company_id' => 'nullable|exists:companies,id',
                'branch_id' => 'nullable|exists:branches,id', // FIXED: Changed from 'id' to 'branch_id'
                'language_preference' => 'nullable|string|in:en,es,fr,de,zh',
            ];

            // Only validate email if it's being changed and not commented out
            if ($request->has('email') && $request->email !== $user->email) {
                $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
            }

            $validated = $request->validate($rules);

            // Handle avatar
            if ($request->hasFile('avatar')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
            } elseif ($request->boolean('remove_avatar') && $user->avatar) {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validated['avatar'] = null;
            } else {
                unset($validated['avatar']);
            }

            // Handle password update
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            // Handle checkbox
            $validated['is_active'] = $request->has('is_active') && $request->boolean('is_active');

            // Remove email from validated if not changed
            if (!isset($validated['email']) || $validated['email'] === $user->email) {
                unset($validated['email']);
            }

            // Update user
            $user->update($validated);

            // Assign roles using Spatie
            if (isset($validated['roles'])) {
                $user->syncRoles($validated['roles']);
            }

            // Assign direct permissions
            if (!empty($validated['permissions'])) {
                $user->syncPermissions($validated['permissions']);
            } else {
                $user->syncPermissions([]);
            }

            // Log activity
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->log('updated user');

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'User updated successfully!');
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

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        try {
            // Prevent deleting your own account
            if ($user->id === Auth::id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'You cannot delete your own account.');
            }

            // Delete avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Log activity before deletion
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->log('deleted user');

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
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        try {
            // Prevent toggling your own status
            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own status.'
                ], 403);
            }

            $user->update(['is_active' => !$user->is_active]);

            // Log activity
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->log($user->is_active ? 'activated user' : 'deactivated user');

            return response()->json([
                'success' => true,
                'is_active' => $user->is_active,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('UserController toggleStatus error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating status.'
            ], 500);
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        try {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => now(),
                'force_password_change' => true,
            ]);

            // Log activity
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->log('reset user password');

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'Password reset successfully. User must change password on next login.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('UserController resetPassword error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error resetting password: ' . $e->getMessage());
        }
    }

    /**
     * Export users to CSV
     */
    public function export(Request $request)
    {
        try {
            $query = User::with(['roles', 'company', 'branch'])
                ->latest();

            // Filter by selected users if provided
            if ($request->has('users')) {
                $userIds = explode(',', $request->users);
                $query->whereIn('id', $userIds);
            }

            $users = $query->get();
            $filename = 'users-export-' . date('Y-m-d-H-i-s') . '.csv';

            return response()->streamDownload(function () use ($users) {
                $handle = fopen('php://output', 'w');

                // Add UTF-8 BOM for Excel compatibility
                fwrite($handle, "\xEF\xBB\xBF");

                // Headers
                fputcsv($handle, [
                    'ID',
                    'Name',
                    'Email',
                    'Phone',
                    'Roles',
                    'Status',
                    'Email Verified',
                    'Last Login',
                    'Created At'
                ]);

                // Data rows
                foreach ($users as $user) {
                    $roles = $user->roles->pluck('name')->join(', ');

                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->phone ?? '',
                        $roles,
                        $user->is_active ? 'Active' : 'Inactive',
                        $user->email_verified_at ? 'Yes' : 'No',
                        $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i') : 'Never',
                        $user->created_at->format('Y-m-d H:i')
                    ]);
                }

                fclose($handle);
            }, $filename);
        } catch (\Exception $e) {
            Log::error('UserController export error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error exporting users.');
        }
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        try {
            $validated = $request->validate([
                'action' => 'required|in:activate,deactivate,delete,assign_role',
                'users' => 'required|array',
                'users.*' => 'exists:users,id',
                'role' => 'required_if:action,assign_role|exists:roles,name'
            ]);

            $users = User::whereIn('id', $validated['users'])
                ->where('id', '!=', auth()->id()) // Exclude current user
                ->get();

            switch ($validated['action']) {
                case 'activate':
                    $users->each->update(['is_active' => true]);

                    // Log activity
                    activity()
                        ->causedBy(Auth::user())
                        ->withProperties(['count' => count($users)])
                        ->log('bulk activated users');

                    return back()->with('success', count($users) . ' users activated successfully.');

                case 'deactivate':
                    $users->each->update(['is_active' => false]);

                    // Log activity
                    activity()
                        ->causedBy(Auth::user())
                        ->withProperties(['count' => count($users)])
                        ->log('bulk deactivated users');

                    return back()->with('success', count($users) . ' users deactivated successfully.');

                case 'delete':
                    foreach ($users as $user) {
                        // Delete avatar if exists
                        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                            Storage::disk('public')->delete($user->avatar);
                        }
                        $user->delete();
                    }

                    // Log activity
                    activity()
                        ->causedBy(Auth::user())
                        ->withProperties(['count' => count($users)])
                        ->log('bulk deleted users');

                    return back()->with('success', count($users) . ' users deleted successfully.');

                case 'assign_role':
                    $role = Role::where('name', $validated['role'])->first();
                    foreach ($users as $user) {
                        $user->syncRoles([$role->name]);
                    }

                    // Log activity
                    activity()
                        ->causedBy(Auth::user())
                        ->withProperties(['role' => $role->name, 'count' => count($users)])
                        ->log('bulk assigned role to users');

                    return back()->with('success', count($users) . ' users assigned to ' . $role->name . ' role.');
            }

            return back()->with('error', 'Invalid action.');
        } catch (\Exception $e) {
            Log::error('UserController bulkAction error: ' . $e->getMessage());
            return back()->with('error', 'Error performing bulk action: ' . $e->getMessage());
        }
    }

    /**
     * Login as another user (impersonation)
     */
    public function loginAs(User $user)
    {
        try {
            // Can't login as yourself
            if ($user->id === Auth::id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'You are already logged in.');
            }

            // Check permission
            if (!Auth::user()->can('impersonate users')) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'You do not have permission to impersonate users.');
            }

            // Store original user info
            session([
                'original_user_id' => Auth::id(),
                'original_user_name' => Auth::user()->name,
                'impersonating' => true
            ]);

            // Login as the user
            Auth::login($user);

            // Log activity
            activity()
                ->causedBy(session('original_user_id'))
                ->performedOn($user)
                ->log('impersonated user');

            return redirect()->route('dashboard')
                ->with('success', 'Now logged in as ' . $user->name . '. Use "Return to Admin" to go back.');
        } catch (\Exception $e) {
            Log::error('UserController loginAs error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error logging in as user.');
        }
    }

    /**
     * Stop impersonation and return to original user
     */
    public function stopImpersonate()
    {
        if (session()->has('original_user_id')) {
            $originalUserId = session('original_user_id');
            session()->forget(['original_user_id', 'original_user_name', 'impersonating']);

            $originalUser = User::find($originalUserId);
            if ($originalUser) {
                Auth::login($originalUser);

                return redirect()->route('admin.users.index')
                    ->with('success', 'Successfully returned to admin panel.');
            }
        }

        return redirect()->route('dashboard')
            ->with('error', 'No impersonation session found.');
    }

    /**
     * Show user's permissions
     */
    public function permissions(User $user)
    {
        if (!Auth::user()->can('manage permissions')) {
            abort(403, 'Unauthorized action.');
        }

        $user->load('roles.permissions', 'permissions');
        $allPermissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0] ?? 'general';
        });

        return view('admin.users.permissions', compact('user', 'allPermissions'));
    }

    /**
     * Sync user's direct permissions
     */
    public function syncPermissions(Request $request, User $user)
    {
        if (!Auth::user()->can('manage permissions')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $validated = $request->validate([
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name'
            ]);

            $user->syncPermissions($validated['permissions'] ?? []);

            // Log activity
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->withProperties(['permissions' => $validated['permissions'] ?? []])
                ->log('updated user permissions');

            return back()->with('success', 'User permissions updated successfully.');
        } catch (\Exception $e) {
            Log::error('UserController syncPermissions error: ' . $e->getMessage());
            return back()->with('error', 'Error updating permissions: ' . $e->getMessage());
        }
    }

    /**
     * Sync user's roles
     */
    public function syncRoles(Request $request, User $user)
    {
        if (!Auth::user()->can('manage permissions')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $validated = $request->validate([
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,name'
            ]);

            $user->syncRoles($validated['roles']);

            // Log activity
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->withProperties(['roles' => $validated['roles']])
                ->log('updated user roles');

            return back()->with('success', 'User roles updated successfully.');
        } catch (\Exception $e) {
            Log::error('UserController syncRoles error: ' . $e->getMessage());
            return back()->with('error', 'Error updating roles: ' . $e->getMessage());
        }
    }

    /**
     * Show user activity logs
     */
    public function activities(User $user)
    {
        if (!Auth::user()->can('view user activities')) {
            abort(403, 'Unauthorized action.');
        }

        $activities = $user->activities()
            ->with('causer')
            ->latest()
            ->paginate(20);

        return view('admin.users.activities', compact('user', 'activities'));
    }

    /**
     * Show user login history
     */
    public function loginHistory(User $user)
    {
        if (!Auth::user()->can('view user activities')) {
            abort(403, 'Unauthorized action.');
        }

        if (!Schema::hasTable('login_logs')) {
            return back()->with('error', 'Login logs feature is not enabled.');
        }

        $loginLogs = $user->loginLogs()
            ->latest('logged_in_at')
            ->paginate(20);

        return view('admin.users.login-history', compact('user', 'loginLogs'));
    }


    /**
     * Show the form for editing user roles.
     */
    public function editRoles(User $user)
    {
        try {
            // Get all available roles
            $roles = Role::orderBy('name')->get();

            // Get user's current role IDs
            $userRoleIds = $user->roles->pluck('id')->toArray();

            return view('admin.users.roles.edit', compact('user', 'roles', 'userRoleIds'));
        } catch (\Exception $e) {
            Log::error('RoleController editRoles error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update user roles.
     */
    public function updateRoles(Request $request, User $user)
    {
        // Check permission
        $this->authorize('manage roles');

        $validated = $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        try {
            DB::beginTransaction();

            // Sync roles
            $user->syncRoles($validated['roles'] ?? []);

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'roles' => $validated['roles'] ?? [],
                    'old_roles' => $user->roles->pluck('name')->toArray()
                ])
                ->log('updated user roles');

            DB::commit();

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'User roles updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to update roles: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing user permissions.
     */
    public function editPermissions(User $user)
    {
        // Check permission
        $this->authorize('manage permissions');

        // Get all permissions grouped by guard name
        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();

        // Get user's direct permissions (excluding role permissions)
        $userPermissionIds = $user->getDirectPermissions()->pluck('id')->toArray();

        return view('admin.users.permissions.edit', compact('user', 'permissions', 'userPermissionIds'));
    }
    /**
     * Update user permissions.
     */
    public function updatePermissions(Request $request, User $user)
    {
        // Check permission
        $this->authorize('manage permissions');

        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            DB::beginTransaction();

            // Get current direct permissions
            $currentPermissions = $user->getDirectPermissions()->pluck('id')->toArray();

            // Sync permissions (only direct permissions)
            $permissionIds = $validated['permissions'] ?? [];
            $user->syncPermissions($permissionIds);

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'permissions_added' => array_diff($permissionIds, $currentPermissions),
                    'permissions_removed' => array_diff($currentPermissions, $permissionIds)
                ])
                ->log('updated user permissions');

            DB::commit();

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'User permissions updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to update permissions: ' . $e->getMessage());
        }
    }
}
