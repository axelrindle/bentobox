<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OpenIdConnectController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('/login')->group(function () {
    Route::get('/email', LoginController::class)
        ->middleware(['guest'])
        ->name('login.email');

    // middleware defined in OpenIdConnectController
    Route::get('/oidc', [OpenIdConnectController::class, 'login'])
        ->name('oidc.login');
    Route::get('/oidc/callback', [OpenIdConnectController::class, 'callback'])
        ->name('oidc.callback');
});

Route::redirect('/', '/dashboard')
    ->name('home');
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/inventory.php';
