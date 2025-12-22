<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        try {
            // Start query
            $query = User::query();

            // Search
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // Status filter
            if ($request->filled('status')) {
                if ($request->status === 'active') {
                    $query->where('is_active', true);
                } elseif ($request->status === 'inactive') {
                    $query->where('is_active', false);
                }
            }

            // Role filter (using simple role column)
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }

            // Paginate results
            $users = $query->orderBy('created_at', 'desc')->paginate(15);

            // Simple statistics
            $totalUsers = User::count();
            $activeUsers = User::where('is_active', true)->count();
            $adminUsers = User::where('role', 'admin')->count();

            $activeUsersPercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0;
            $adminPercentage = $totalUsers > 0 ? round(($adminUsers / $totalUsers) * 100, 1) : 0;

            // Today's logins
            $todayLogins = User::whereNotNull('last_login_at')
                ->whereDate('last_login_at', today())
                ->count();

            // Recent activity (users created or updated in last 7 days)
            $recentActivity = User::where('created_at', '>=', now()->subDays(7))
                ->orWhere('updated_at', '>=', now()->subDays(7))
                ->count();

            // Simple role options for filter
            $roles = [
                'admin' => 'Administrator',
                'manager' => 'Manager',
                'staff' => 'Staff',
                'viewer' => 'Viewer Only'
            ];

            return view('admin.users.index', compact(
                'users',
                'totalUsers',
                'activeUsers',
                'adminUsers',
                'activeUsersPercentage',
                'adminPercentage',
                'todayActive',
                'roles'
            ));
        } catch (\Exception $e) {
            Log::error('UserController index error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Error loading users. Please try again.');
        }
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        // Simple role options
        $roles = [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            'viewer' => 'Viewer Only'
        ];

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        try {
            // Simple validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'nullable|string|max:20',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => 'required|in:admin,manager,staff,viewer',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024', // 1MB max
                'is_active' => 'boolean'
            ];

            $validated = $request->validate($rules);

            // Handle avatar upload
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'avatar' => $avatarPath,
                'is_active' => $request->boolean('is_active', true),
                'email_verified_at' => now(), // Auto-verify for admin-created users
                'created_by' => Auth::id()
            ]);

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
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        // Prevent editing super admin by non-super admin
        if ($user->role === 'super_admin' && Auth::user()->role !== 'super_admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Only super admin can edit super admin accounts.');
        }

        $roles = [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            'viewer' => 'Viewer Only'
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        try {
            // Prevent modifying super admin by non-super admin
            if ($user->role === 'super_admin' && Auth::user()->role !== 'super_admin') {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Only super admin can modify super admin accounts.');
            }

            // Validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'role' => 'required|in:admin,manager,staff,viewer',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
                'remove_avatar' => 'boolean',
                'password' => 'nullable|min:8|confirmed',
                'is_active' => 'boolean'
            ];

            $validated = $request->validate($rules);

            // Handle avatar
            if ($request->hasFile('avatar')) {
                // Delete old avatar
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

            // Update user
            $user->update($validated);

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

            // Prevent deleting super admin
            if ($user->role === 'super_admin') {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Super admin accounts cannot be deleted.');
            }

            // Delete avatar if exists
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

            // Prevent toggling super admin
            if ($user->role === 'super_admin' && Auth::user()->role !== 'super_admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only super admin can change super admin status.'
                ], 403);
            }

            $user->update(['is_active' => !$user->is_active]);

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
    public function export()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->get();
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
                    'Role',
                    'Status',
                    'Email Verified',
                    'Last Login',
                    'Created At'
                ]);

                // Data rows
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->phone ?? '',
                        ucfirst($user->role),
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
     * Simple bulk actions
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
            $currentUserId = Auth::id();

            $processed = 0;
            $skipped = 0;

            foreach ($users as $user) {
                // Skip current user
                if ($user->id === $currentUserId) {
                    $skipped++;
                    continue;
                }

                // Skip super admin for non-super admin users
                if ($user->role === 'super_admin' && Auth::user()->role !== 'super_admin') {
                    $skipped++;
                    continue;
                }

                try {
                    switch ($request->action) {
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
                    Log::warning("Bulk action failed for user {$user->id}: " . $e->getMessage());
                }
            }

            $message = "Action completed. {$processed} users processed.";
            if ($skipped > 0) {
                $message .= " {$skipped} users skipped.";
            }

            return redirect()->route('admin.users.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('UserController bulkAction error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error performing bulk action.');
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

            // Store original user info
            session([
                'original_user_id' => Auth::id(),
                'original_user_name' => Auth::user()->name,
                'impersonating' => true
            ]);

            // Login as the user
            Auth::login($user);

            Log::info('User ' . session('original_user_id') . ' logged in as user ' . $user->id);

            return redirect('/dashboard')
                ->with('success', 'Now logged in as ' . $user->name . '. Use "Return to Admin" to go back.');
        } catch (\Exception $e) {
            Log::error('UserController loginAs error: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Error logging in as user.');
        }
    }
}
