<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // If no specific role is provided, just check if user is authenticated
        if (empty($roles)) {
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

        // Check if user has any of the required roles
        $hasRole = false;
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                $hasRole = true;
                break;
            }
        }

        // If user doesn't have role, deny access
        if (!$hasRole) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have the required role to access this resource.',
                    'required_roles' => $roles
                ], 403);
            }

            return redirect()->route('dashboard')->with('error',
                'You do not have the required role to access that resource.'
            );
        }

        return $next($request);
    }
}
