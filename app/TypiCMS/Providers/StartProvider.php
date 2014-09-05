<?php
namespace TypiCMS\Providers;

use App;
use Config;
use Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use TypiCMS\Commands\Install;
use TypiCMS\Commands\CacheKeyPrefix;
use TypiCMS\Commands\Database;

class StartProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands('command.install');
        $this->commands('command.cachekeyprefix');
        $this->commands('command.database');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Set app locale on public side.
        |--------------------------------------------------------------------------|
        */
        if (Request::segment(1) != 'admin') {

            $firstSegment = Request::segment(1);
            if (in_array($firstSegment, Config::get('app.locales'))) {
                Config::set('app.locale', $firstSegment);
            }
            // Not very reliable, need to be refactored
            setlocale(LC_ALL, App::getLocale() . '_' . ucfirst(App::getLocale()));

        }

        /*
        |--------------------------------------------------------------------------
        | Bind commands.
        |--------------------------------------------------------------------------|
        */
        $this->app->bind('command.install', function () {
            return new Install(new Filesystem);
        });
        $this->app->bind('command.cachekeyprefix', function () {
            return new CacheKeyPrefix(new Filesystem);
        });
        $this->app->bind('command.database', function () {
            return new Database(new Filesystem);
        });

        /*
        |--------------------------------------------------------------------------
        | Get custom routes for public side modules.
        |--------------------------------------------------------------------------|
        */
        $this->app->singleton('TypiCMS.routes', function (Application $app) {
            return $app->make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')->getForRoutes();
        });

        /*
        |--------------------------------------------------------------------------
        | Register modules.
        |--------------------------------------------------------------------------|
        */
        $this->app->register('TypiCMS\Modules\News\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Places\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Events\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Projects\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Categories\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Tags\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Partners\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Contacts\Providers\ModuleProvider');

        $this->app->register('TypiCMS\Modules\Translations\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Blocks\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Settings\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Users\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Groups\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Files\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Galleries\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Dashboard\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Menus\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Sitemap\Providers\ModuleProvider');
        // Pages and menulinks need to be at last for routing to work.
        $this->app->register('TypiCMS\Modules\Menulinks\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Pages\Providers\ModuleProvider');
    }
}
