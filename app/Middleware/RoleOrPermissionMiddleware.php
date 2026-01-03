<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleOrPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $rolesOrPermissions
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$rolesOrPermissions): Response
    {
        // If no parameters provided, just check if user is authenticated
        if (empty($rolesOrPermissions)) {
            if (!auth()->check()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        }

        // If user is not authenticated
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has any of the required roles or permissions
        $hasAccess = false;
        foreach ($rolesOrPermissions as $roleOrPermission) {
            if ($user->hasRole($roleOrPermission) || $user->can($roleOrPermission)) {
                $hasAccess = true;
                break;
            }
        }

        // If user doesn't have access, deny
        if (!$hasAccess) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have the required role or permission to access this resource.',
                    'required' => $rolesOrPermissions
                ], 403);
            }

            return redirect()->route('dashboard')->with('error',
                'You do not have the required role or permission to access that resource.'
            );
        }

        return $next($request);
    }
}
