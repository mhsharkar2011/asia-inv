<?php

namespace App\Models;

use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'login_type',
        'status',
        'failure_reason',
        'logged_in_at',
        'logged_out_at',
        'session_duration',
    ];

    protected $casts = [
        'logged_in_at' => 'datetime',
        'logged_out_at' => 'datetime',
    ];

    /**
     * Get the user that owns the login log
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for successful logins
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope for failed logins
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for recent logs (last X days)
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('logged_in_at', '>=', now()->subDays($days));
    }

    /**
     * Calculate session duration in minutes
     */
    public function getSessionDurationInMinutesAttribute()
    {
        return $this->session_duration ? round($this->session_duration / 60, 2) : null;
    }

    /**
     * Check if session is still active
     */
    public function getIsActiveSessionAttribute()
    {
        return $this->logged_out_at === null &&
               $this->logged_in_at > now()->subHours(12); // Consider active if logged in within last 12 hours
    }
}
