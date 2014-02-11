<?php namespace TypiCMS\Providers;

use Illuminate\Support\ServiceProvider;

class StartProvider extends ServiceProvider {

    public function register() {

        $this->app->register('TypiCMS\Modules\News\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Places\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Events\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Projects\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Pages\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Menus\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Menulinks\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Files\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Categories\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Users\Providers\ModuleProvider');
        $this->app->register('TypiCMS\Modules\Groups\Providers\ModuleProvider');

    }

}