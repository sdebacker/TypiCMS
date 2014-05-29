<?php
namespace TypiCMS\Providers;

use Illuminate\Support\ServiceProvider;

class StartProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('TypiCMS.routes', function ($app) {
            return $app->make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')->getForRoutes();
        });
        $this->app->register('TypiCMS\Modules\News\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Places\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Events\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Projects\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Categories\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Tags\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Contacts\Providers\ModuleProvider');

        $this->app->register('TypiCMS\Modules\Translations\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Settings\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Users\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Groups\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Files\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Galleries\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Dashboard\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Menus\Providers\ModuleProvider');
        // Pages and menulinks need to be at last for routing to work.
        $this->app->register('TypiCMS\Modules\Menulinks\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Pages\Providers\ModuleProvider');
    }
}
