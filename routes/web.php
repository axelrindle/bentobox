<?php

use App\Http\Controllers\OpenIdConnectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/login/email', function (Request $request) {
    return Inertia::render('auth/Login/Internal', [
        'usedOidc' => $request->cookies->has(OpenIdConnectController::COOKIE_LAST_USED) ? $request->cookies->getBoolean(OpenIdConnectController::COOKIE_LAST_USED) : null,
    ]);
})->middleware(['guest'])->name('login.email');

Route::get('/login/oidc', [OpenIdConnectController::class, 'login'])
    ->name('oidc.login');
Route::get('/login/oidc/callback', [OpenIdConnectController::class, 'callback'])
    ->name('oidc.callback');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/inventory.php';
