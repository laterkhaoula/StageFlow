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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $userRoles = $user->roles;

        if ($userRoles->isNotEmpty()) {
            abort_unless($userRoles->contains('name', $role), 403);

            return $next($request);
        }

        abort_unless(
            is_string($user->role ?? null) && strtolower((string) $user->role) === strtolower($role),
            403
        );

        return $next($request);
    }
}
