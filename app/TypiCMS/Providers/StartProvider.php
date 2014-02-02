<?php namespace TypiCMS\Providers;

use Illuminate\Support\ServiceProvider;

class StartProvider extends ServiceProvider {

    public function register() {

        $this->app->register('TypiCMS\Modules\Places\Providers\ModuleProvider');

    }

}