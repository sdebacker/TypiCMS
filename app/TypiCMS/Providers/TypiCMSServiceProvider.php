<?php
namespace TypiCMS\Providers;

use Illuminate\Support\ServiceProvider;
use TypiCMS\Services\TypiCMS;

class TypiCMSServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['typicms'] = $this->app->share(function ($app) {
            return new TypiCMS;
        });

    }
}
