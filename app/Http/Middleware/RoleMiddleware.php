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

        $laratrustRoles = method_exists($user, 'roles') ? $user->roles()->get() : collect();

        if ($laratrustRoles->isNotEmpty()) {
            $hasRequiredRole = $laratrustRoles->contains(
                fn ($userRole) => strtolower((string) ($userRole->name ?? '')) === strtolower($role)
            );

            if (! $hasRequiredRole) {
                abort(403);
            }

            return $next($request);
        }

        $hasLegacyRole = is_string($user->role ?? null) && strtolower((string) $user->role) === strtolower($role);

        if (! $hasLegacyRole) {
            abort(403);
        }

        return $next($request);
    }
}