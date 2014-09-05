<?php
namespace TypiCMS\Modules\Sitemap\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';
    }

    public function register()
    {
    }
}
