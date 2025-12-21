<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\Department;
use App\Models\Admin\Organization;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $status = $request->input('status');

        $users = User::with(['branch', 'company'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            })
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->when($status, function ($query, $status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $activeUsersPercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;
        $adminUsers = User::where('role', 'admin')->orWhere('role', 'super_admin')->count();
        $adminPercentage = $totalUsers > 0 ? round(($adminUsers / $totalUsers) * 100) : 0;

        // Today's logins (assuming you have last_login_at field)
        $todayLogins = User::whereDate('last_login_at', today())->count();

        // Recent activity (last 24 hours)
        $recentActivity = User::where('created_at', '>=', now()->subDay())->count();

        $branches = Branch::all();
        $roles = [
            'super_admin' => 'Super Admin',
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            'customer' => 'Customer'
        ];

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'activeUsersPercentage',
            'adminUsers',
            'adminPercentage',
            'todayLogins',
            'recentActivity',
            'branches',
            'totalUsers',
            'roles'
        ));
    }

    public function create()
    {
        $companies = Organization::where('type', 'company')->get();
        $branches = Branch::all();
        $roles = [
            'super_admin' => 'Super Admin',
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            'customer' => 'Customer',
            'viewer' => 'Viewer',
            'user' => 'User',

        ];


        return view('admin.users.create', compact('branches', 'roles', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:super_admin,admin,manager,user,viewer',
            'company_id' => 'nullable|exists:organizations,id',
            'branch_id' => 'nullable|exists:branches,id',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'language_preference' => 'nullable|in:en,es,fr,de,zh',
            'is_active' => 'boolean',
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'company_id' => $request->company_id,
            'branch_id' => $request->branch_id,
            'address' => $request->address,
            'avatar' => $avatarPath,
            'language_preference' => $request->language_preference ?? 'en',
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(), // Auto-verify for admin-created users
        ]);

        // Send welcome email if needed
        if ($request->boolean('send_welcome_email')) {
            // Mail::to($user->email)->send(new WelcomeEmail($user, $request->password));
        }

        return redirect()->route('admin.users.index') // Updated route name
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('branch', 'company');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $companies = Organization::where('type', 'company')->get();
        $branches = Branch::all();
        $roles = [
            'super_admin' => 'Super Admin',
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            'customer' => 'Customer'
        ];

        return view('admin.users.edit', compact('user', 'branches', 'roles', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,manager,staff,customer',
            'branch_id' => 'nullable|exists:branches,id',
            'company_id' => 'nullable|exists:organizations,id',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'language_preference' => 'nullable|in:en,es,fr,de,zh',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
            'force_password_change' => 'boolean',
            'two_factor_auth' => 'boolean',
        ];

        // Remove unique rule for username if not provided
        if (!$request->has('username') || $request->username === $user->username) {
            $rules['username'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        } elseif ($request->has('remove_avatar')) {
            // Remove avatar if requested
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = null;
        } else {
            // Keep existing avatar
            unset($validated['avatar']);
        }

        // Handle password update
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Handle email verification
        if ($request->has('verify_email')) {
            $validated['email_verified_at'] = now();
        }

        // Handle boolean fields
        $validated['is_active'] = $request->boolean('is_active');
        $validated['force_password_change'] = $request->boolean('force_password_change');
        $validated['two_factor_auth'] = $request->boolean('two_factor_auth');

        // Update user
        $user->update($validated);

        // Redirect based on request source
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'user' => $user->fresh()
            ]);
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        // Prevent deactivating own account
        if ($user->id === Auth::id() && $user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot deactivate your own account.'
            ]);
        }

        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active
        ]);
    }

    public function verifyEmail(User $user)
    {
        $user->update(['email_verified_at' => now()]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Email verified successfully.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
            'force_password_change' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password reset successfully.');
    }

    public function loginAs(User $user)
    {
        // Store current user ID to switch back
        session(['original_user_id' => Auth::id()]);
        Auth::login($user);
        return redirect()->route('admin.dashboard')
            ->with('success', 'Logged in as ' . $user->name);
    }

    public function export()
    {
        // Export users to CSV/Excel
        return response()->streamDownload(function () {
            $users = User::all();
            $handle = fopen('php://output', 'w');

            // Add headers
            fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Status', 'Created At']);

            // Add data
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($handle);
        }, 'users-' . date('Y-m-d') . '.csv');
    }
}
