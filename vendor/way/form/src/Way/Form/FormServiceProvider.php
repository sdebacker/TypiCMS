<?php namespace Way\Form;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class FormServiceProvider extends ServiceProvider {

    public function register() {}

    public function boot()
    {
        $this->package('way/form');

        AliasLoader::getInstance()->alias('FormField', 'Way\Form\FormField');
    }
}
