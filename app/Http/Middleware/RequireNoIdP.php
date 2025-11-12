<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Disallows access to a route when a user is provided
 * by an external identify provider (IdP) such as Keycloak.
 */
class RequireNoIdP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->is_external) {
            return redirect()->back()->withErrors([
                'form' => "You're authenticated through an Identity Provider and thus your profile remains read-only.",
            ]);
        }

        return $next($request);
    }
}
