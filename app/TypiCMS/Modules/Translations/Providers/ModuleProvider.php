<?php namespace TypiCMS\Modules\Translations\Providers;

use View;
use Config;

use Illuminate\Support\ServiceProvider;

// Tags
use TypiCMS\Modules\Tags\Models\TagInterface;

// Model
use TypiCMS\Modules\Translations\Models\Translation;

// Repo
use TypiCMS\Modules\Translations\Repositories\EloquentTranslation;

// Cache
use TypiCMS\Modules\Translations\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Translations\Services\Form\TranslationForm;
use TypiCMS\Modules\Translations\Services\Form\TranslationFormLaravelValidator;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';

		// Require breadcrumbs
		// require __DIR__ . '/../breadcrumbs.php';

		// Add view dir
		View::addLocation(__DIR__ . '/../Views');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Translations\Repositories\TranslationInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			$repository = new EloquentTranslation(
				new Translation,
				$app->make('TypiCMS\Modules\Tags\Repositories\TagInterface')
			);
			if ( ! Config::get('app.cache')) {
				return $repository;
			}
			$laravelCache = new LaravelCache($app['cache'], 'Translations', 10);
			return new CacheDecorator($repository, $laravelCache);
		});

		$app->bind('TypiCMS\Modules\Translations\Services\Form\TranslationForm', function($app)
		{
			return new TranslationForm(
				new TranslationFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Translations\Repositories\TranslationInterface')
			);
		});

	}

}