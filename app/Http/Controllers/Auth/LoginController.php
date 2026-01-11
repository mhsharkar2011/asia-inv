<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Traits\LogsUserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use LogsUserActivity;

    // ... existing code ...

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = Auth::user();

            // Log successful login
            $loginLog = $this->logLoginActivity($user, $request);

            // Store login log ID in session for logout
            session(['login_log_id' => $loginLog->id]);

            return $this->sendLoginResponse($request);
        }

        // Log failed login attempt
        if ($user = User::where('email', $request->email)->first()) {
            $this->logLoginActivity($user, $request, 'failed', 'Invalid credentials');
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $loginLogId = session('login_log_id');

        // Log logout activity
        if ($user) {
            $this->logLogoutActivity($user, $loginLogId);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
