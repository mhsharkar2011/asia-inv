<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        // Check if registration is open to public (you can control this via config)
        if (!config('app.registration_open', false)) {
            return redirect()->route('login')
                ->with('error', 'Registration is currently closed. Please contact administrator.');
        }

        // Get companies for selection (if needed)
        $companies = Company::where('type', 'company')->get(['id', 'name']);

        return view('auth.register', compact('companies'));
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        // Check if registration is open
        if (!config('app.registration_open', false)) {
            return redirect()->route('register')
                ->with('error', 'Registration is currently closed.');
        }

        // Validation rules for public registration
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_id' => ['nullable', 'exists:companies,id'],
            'terms' => ['required', 'accepted'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user with minimal permissions
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id,
            'role' => 'user', // Default role for public registration
            'language_preference' => 'en',
            'is_active' => config('app.auto_activate_users', false), // Auto-activate or require admin approval
            'email_verified_at' => config('app.auto_verify_email', false) ? now() : null,
            'created_by' => null, // Self-registered
        ]);

        // Assign default role (usually 'user' or 'customer')
        if (class_exists(Role::class)) {
            $defaultRole = Role::where('name', 'user')->first();
            if ($defaultRole) {
                $user->assignRole($defaultRole);
            }
        }

        // Log the user in if auto-activated
        if ($user->is_active && config('app.auto_login_after_registration', false)) {
            Auth::login($user);
            return redirect()->route('dashboard')
                ->with('success', 'Registration successful! Welcome to our platform.');
        }

        // Send email verification if not auto-verified
        if (!$user->email_verified_at && config('app.send_verification_email', true)) {
            // You can implement email verification here
            // $user->sendEmailVerificationNotification();
        }

        // Redirect based on activation status
        if ($user->is_active) {
            return redirect()->route('login')
                ->with('success', 'Registration successful! Please login to continue.');
        } else {
            return redirect()->route('login')
                ->with('info', 'Registration submitted successfully! Your account is pending admin approval.');
        }
    }

    /**
     * Show admin user creation form (for admins only)
     */
    public function showAdminCreateForm()
    {
        // This should be accessed via admin panel
        $companies = Company::where('type', 'company')->get(['id', 'name']);
        $roles = [];

        if (class_exists(Role::class)) {
            $roles = Role::pluck('name', 'name')->toArray();
        }

        return view('admin.users.create', compact('companies', 'roles'));
    }

    /**
     * Handle admin user creation (for admins only)
     */
    public function adminCreateUser(Request $request)
    {
        // This should be protected by admin middleware
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_id' => ['nullable', 'exists:companies,id'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],
            'is_active' => ['boolean'],
            'send_welcome_email' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id,
            'language_preference' => 'en',
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => $request->boolean('verify_email') ? now() : null,
            'created_by' => Auth::id(),
        ]);

        // Assign selected roles
        if (class_exists(Role::class)) {
            $user->syncRoles($request->roles);
        }

        // Send welcome email if requested
        if ($request->boolean('send_welcome_email')) {
            // Implement welcome email
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }
}
