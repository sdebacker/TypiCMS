<?php namespace TypiCMS\Services\ListBuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Config;
use Request;
use TypiCMS\Services\ListBuilder\ListBuilder;

class ListBuilderServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->bind('MainMenu', function($app, $parameters)
		{
			$items = $this->app->make('TypiCMS\Repositories\Menulink\MenulinkInterface')->getMenu('main');
			return with(new ListBuilder($items))->buildPublic()->toHtml($parameters);
		});

		$this->app->bind('FooterMenu', function($app, $parameters)
		{
			$items = $this->app->make('TypiCMS\Repositories\Menulink\MenulinkInterface')->getMenu('footer');
			return with(new ListBuilder($items))->buildPublic()->toHtml($parameters);
		});

		$this->app->bind('LanguagesMenu', function()
		{
			return with(new ListBuilder)->languagesMenu();
		});

	}

}