<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $permissions
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // If no specific permission is provided, just check if user is authenticated
        if (empty($permissions)) {
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

        // Check if user has any of the required permissions
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                $hasPermission = true;
                break;
            }
        }

        // If user doesn't have permission, deny access
        if (!$hasPermission) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have permission to access this resource.',
                    'required_permissions' => $permissions
                ], 403);
            }

            // Store intended URL for redirect after permission is granted
            if (!$request->is('admin*')) {
                session()->put('url.intended', $request->fullUrl());
            }

            return redirect()->route('dashboard')->with('error',
                'You do not have permission to access that resource.'
            );
        }

        return $next($request);
    }
}
