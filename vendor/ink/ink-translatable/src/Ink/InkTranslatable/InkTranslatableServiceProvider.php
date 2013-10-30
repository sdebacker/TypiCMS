<?php namespace Ink\InkTranslatable;

use Illuminate\Support\ServiceProvider;

class InkTranslatableServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('ink/ink-translatable');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->registerTranslatable();
        $this->registerEvents();
	}

    /**
     * Register the Translatable class
     *
     * @return void
     */
    public function registerTranslatable()
    {
        $this->app['translatable'] = $this->app->share(function($app)
        {
            $locales = $app['config']->get('app.locales');
            return new Translatable($locales);
        });
    }

    /**
     * Register the listener events
     *
     * @return void
     */
    public function registerEvents()
    {
        $app = $this->app;

        $app['events']->listen('eloquent.saved*', function($model) use ($app)
        {
            $app['translatable']->translate($model);
        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('translatable');
	}

}