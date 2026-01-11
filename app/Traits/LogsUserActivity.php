// app/Traits/LogsUserActivity.php
<?php

namespace App\Traits;

use App\Models\LoginLog;
use Illuminate\Http\Request;

trait LogsUserActivity
{
    /**
     * Log user login activity
     */
    protected function logLoginActivity($user, Request $request, $status = 'success', $failureReason = null)
    {
        return LoginLog::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'login_type' => 'web',
            'status' => $status,
            'failure_reason' => $failureReason,
            'logged_in_at' => now(),
        ]);
    }

    /**
     * Log user logout activity
     */
    protected function logLogoutActivity($user, $loginLogId = null)
    {
        if ($loginLogId) {
            $log = LoginLog::where('id', $loginLogId)
                ->where('user_id', $user->id)
                ->whereNull('logged_out_at')
                ->first();

            if ($log) {
                $loggedInAt = $log->logged_in_at;
                $log->update([
                    'logged_out_at' => now(),
                    'session_duration' => now()->diffInSeconds($loggedInAt),
                ]);
            }
        } else {
            // Find the latest active session
            $log = LoginLog::where('user_id', $user->id)
                ->whereNull('logged_out_at')
                ->latest('logged_in_at')
                ->first();

            if ($log) {
                $loggedInAt = $log->logged_in_at;
                $log->update([
                    'logged_out_at' => now(),
                    'session_duration' => now()->diffInSeconds($loggedInAt),
                ]);
            }
        }
    }
}
