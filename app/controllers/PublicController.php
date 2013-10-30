<?php namespace App\Controllers;

use View;
use Config;

class PublicController extends BaseController {

	/**
	 * Fonction appelée depuis routes.php.
	 * affiche le template publi.root (page de choix de langue)
	 *
	 * @return void
	 */
	public function root()
	{
		$locales = Config::get('app.locales');
		$this->layout->content = View::make('public.root')
			->with('locales', $locales);
	}

}