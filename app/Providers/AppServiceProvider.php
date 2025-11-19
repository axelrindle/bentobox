<?php

namespace App\Providers;

use App\Services\OIDC;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory as ValidatorFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OIDC::class, function (Application $app) {
            return new OIDC(
                $app->make(Config::class)->get('oidc'),
                $app->make(HttpFactory::class),
                $app->make(ResponseFactory::class),
                $app->make(SessionManager::class),
                $app->make(UrlGenerator::class),
                $app->make(ValidatorFactory::class),
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
