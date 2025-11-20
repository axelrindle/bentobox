<?php

namespace App\Http\Controllers\Auth;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RequireOidcEnabled;
use App\Services\OIDC;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OpenIdConnectController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware(RequireOidcEnabled::class),
        ];
    }

    public function login(Request $request, OIDC $oidc): RedirectResponse
    {
        return $oidc->redirect()->withCookie(Constants::COOKIE_LAST_USED, true);
    }

    public function callback(Request $request, OIDC $oidc): RedirectResponse
    {
        $oidc->callback($request);

        return response()->redirectToRoute('dashboard');
    }
}
