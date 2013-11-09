<?php namespace TypiCMS\Services;

use Request;
use Config;

use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;

class TranslationServiceProvider extends \Illuminate\Translation\TranslationServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerLoader();

		$lang = Request::segment(1);
		if (in_array($lang, Config::get('app.locales'))) {
			Config::set('app.contentlocale', $lang);
		}

		$this->app['translator'] = $this->app->share(function($app)
		{
			$loader = $app['translation.loader'];

			// When registering the translator component, we'll need to set the default
			// locale as well as the fallback locale. So, we'll grab the application
			// configuration so we can easily get both of these values from there.
			$locale = in_array(Request::segment(1), Config::get('app.locales')) ? $app['config']['app.contentlocale'] : $app['config']['app.locale'] ;

			$trans = new Translator($loader, $locale);

			return $trans;
		});
	}

}
