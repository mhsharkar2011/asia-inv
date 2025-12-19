<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $status = $request->input('status');

        $users = User::with(['Branch'])
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

    // public function create()
    // {
    //     $branchs = Branch::all();
    //     $roles = [
    //         'super_admin' => 'Super Admin',
    //         'admin' => 'Administrator',
    //         'manager' => 'Manager',
    //         'staff' => 'Staff',
    //         'customer' => 'Customer'
    //     ];

    //     return view('admin.users.create', compact('branchs', 'roles'));
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:super_admin,admin,manager,staff,customer',
            'branch_id' => 'nullable|exists:branchs,id',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'boolean',
            'send_welcome_email' => 'boolean',
            'force_password_change' => 'boolean',
            'two_factor_auth' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch_id' => $request->branch_id,
            'position' => $request->position,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'is_active' => $request->boolean('is_active'),
            'email_verified_at' => $request->boolean('send_welcome_email') ? null : now(),
            'force_password_change' => $request->boolean('force_password_change'),
            'two_factor_auth' => $request->boolean('two_factor_auth'),
        ]);

        if ($request->boolean('send_welcome_email')) {
            // Send welcome email
            // Mail::to($user->email)->send(new WelcomeEmail($user, $request->password));
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'phone' => $user->phone,
            'address' => $user->address,
            'is_active' => $user->is_active,
            'last_login_at' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : null,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function edit(User $user)
    {
        $branchs = Branch::all();
        $roles = [
            'super_admin' => 'Super Admin',
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            'customer' => 'Customer'
        ];

        return view('users.edit', compact('user', 'Branchs', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,manager,staff,customer',
            'Branch_id' => 'nullable|exists:branches,id',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'boolean',
            'force_password_change' => 'boolean',
            'two_factor_auth' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'role' => $request->role,
            'branch_id' => $request->branch_id,
            'position' => $request->position,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'is_active' => $request->boolean('is_active'),
            'force_password_change' => $request->boolean('force_password_change'),
            'two_factor_auth' => $request->boolean('two_factor_auth'),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        // Prevent deactivating own account
        if ($user->id === auth()->id() && $user->is_active) {
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

        return redirect()->route('users.index')
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

        return redirect()->route('users.index')
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
