<?php

namespace App\Http\Middleware;

use App\Services\OIDC;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireOidcEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app(OIDC::class)->isEnabled()) {
            abort(503, 'oidc is not enabled');
        }

        return $next($request);
    }
}
