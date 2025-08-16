<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        
        // Check if user has the required role
        $hasRole = match($role) {
            'admin' => $user->is_admin,
            'staff' => $user->is_staff,
            'franchise' => $user->is_franchise,
            'frontdesk' => $user->is_frontdesk,
            default => false
        };

        if (!$hasRole) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}