<?php

namespace App\Http\Controllers;

use App\Services\OIDC;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OpenIdConnectController extends Controller
{
    public const COOKIE_LAST_USED = 'usedOidc';

    public function login(Request $request, OIDC $oidc): RedirectResponse
    {
        return $oidc->redirect()->withCookie(self::COOKIE_LAST_USED, true);
    }

    public function callback(Request $request, OIDC $oidc): RedirectResponse
    {
        $oidc->callback($request);

        return response()->redirectToRoute('dashboard');
    }
}
