<?php

namespace App\Providers;

use App\Services\OIDC;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Client\Factory;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OIDC::class, function (Application $app) {
            return new OIDC(
                $app->make(Repository::class)->get('oidc'),
                $app->make(UrlGenerator::class),
                $app->make(ResponseFactory::class),
                $app->make(Factory::class),
                $app->make(SessionManager::class),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
