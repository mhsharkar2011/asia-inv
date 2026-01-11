<?php

namespace App\Models\Admin;

use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\LoginLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role',
        'is_active',
        'email_verified_at',
        'last_login_at',
        'language_preference',
        'created_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Simple role checking methods
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isViewer()
    {
        return $this->role === 'viewer';
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for searching users
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function logs()
    {
        // If you have an ActivityLog or LoginLog model
        return $this->hasMany(ActivityLog::class, 'user_id')->latest();
    }

    /**
     * Get the user's activities
     */
    public function activities()
    {
        // If you have an Activity model
        return $this->hasMany(Activity::class, 'user_id')->latest();
    }

    /**
     * Get the user's login logs (alternative if you don't have logs)
     */
    // public function loginLogs()
    // {
    //     return $this->hasMany(LoginLog::class, 'user_id')->latest();
    // }

    /**
     * Get the company that owns the user
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the branch that owns the user
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the user's login logs
     */
    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class)->latest('logged_in_at');
    }

    /**
     * Get the user's successful login logs
     */
    public function successfulLoginLogs()
    {
        return $this->hasMany(LoginLog::class)->successful()->latest('logged_in_at');
    }

    /**
     * Get the user's last login
     */
    public function getLastLoginAttribute()
    {
        return $this->successfulLoginLogs()->first();
    }

    /**
     * Get the user's login count
     */
    public function getLoginCountAttribute()
    {
        return $this->successfulLoginLogs()->count();
    }

    /**
     * Get the user's failed login attempts in the last hour
     */
    public function getRecentFailedLoginAttemptsAttribute()
    {
        return $this->loginLogs()
            ->failed()
            ->where('logged_in_at', '>=', now()->subHour())
            ->count();
    }

      /**
     * Get the user's recent activities (last 24 hours)
     */
    public function recentActivities()
    {
        return $this->hasMany(Activity::class)->recent();
    }

}
