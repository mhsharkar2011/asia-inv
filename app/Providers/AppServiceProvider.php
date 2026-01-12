<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bangladeshi Taka formatter
        Blade::directive('bdt', function ($expression) {
            return "<?php echo '৳ ' . number_format($expression, 2); ?>";
        });

        // Role checking directives
        Blade::if('hasrole', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('hasanyrole', function ($roles) {
            if (!auth()->check()) return false;

            $rolesArray = is_array($roles) ? $roles : explode(',', $roles);
            return auth()->user()->hasAnyRole($rolesArray);
        });

        Blade::if('hasallroles', function ($roles) {
            if (!auth()->check()) return false;

            $rolesArray = is_array($roles) ? $roles : explode(',', $roles);
            return auth()->user()->hasAllRoles($rolesArray);
        });

        // Alternative @role directive (Laravel 9+ style)
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // Permission checking with role fallback
        Blade::if('canorrole', function ($permission, $role = null) {
            if (!auth()->check()) return false;

            $user = auth()->user();

            // Check permission first
            if ($user->can($permission)) {
                return true;
            }

            // Fallback to role check if role is provided
            if ($role && $user->hasRole($role)) {
                return true;
            }

            return false;
        });

        // Check if user is elevated (admin or super-admin)
        Blade::if('iselevated', function () {
            return auth()->check() && auth()->user()->hasAnyRole(['super-admin', 'admin']);
        });

        // Format role name for display
        Blade::directive('displayrole', function ($role) {
            return "<?php echo ucwords(str_replace('-', ' ', {$role})); ?>";
        });
    }
}
