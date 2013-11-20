<?php namespace App\Controllers;

use View;
use Config;

class PublicController extends BaseController {

	/**
	 * Show lang chooser, redirect to browser lang or redirect to default lang
	 *
	 * @return void
	 */
	public function root()
	{
		$locales = Config::get('app.locales');


		if (Config::get('typicms.skipLangChooser')) {

			$locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			! in_array($locale, $locales) and $locale = Config::get('app.locale');

			return Redirect::route($locale.'.projects');

		}


		$this->title['parent'] = 'Choose your language';

		$this->layout->content = View::make('public.root')
			->with('locales', $locales);
	}

}