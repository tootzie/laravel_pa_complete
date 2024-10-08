<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Assuming you store the user's role in the session or user model
        $userRoleId = auth()->user()->userRole->id;

        // Check if the user's role is in the list of allowed roles
        if (!in_array($userRoleId, $roles)) {
            // Redirect or throw an error if the user doesn't have the right role
            abort(403, 'Unauthorized action');
        }

        return $next($request);
        }
}
