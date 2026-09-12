<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Behind Cloudflare/an SSL-terminating proxy the origin sees plain
        // HTTP, which would make asset() emit http:// URLs and trip mixed
        // content. Force https for generated URLs in production.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
