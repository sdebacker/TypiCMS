<?php namespace TypiCMS\Modules\Translations\Loaders;

use App;

use Illuminate\Translation\LoaderInterface;
use TypiCMS\Modules\Translations\Loaders\Loader;

class DatabaseLoader extends Loader implements LoaderInterface {

	protected $repository;

	/**
	 * 	Create a new database loader instance.
	 *
	 *	@return TypiCMS\Modules\Translations\Repositories\TranslationInterface $repository
	 *	@param 	\Illuminate\Foundation\Application $app
	 */
	public function __construct($repository)
	{
		$this->repository     = $repository;
	}

	/**
	 * Load the messages strictly for the given locale.
	 *
	 * @param  Language  	$language
	 * @param  string  		$group
	 * @param  string  		$namespace
	 * @return array
	 */
	public function loadRaw($locale, $group, $namespace = null)
	{
		return $this->repository->getAllToArray($locale);
	}
}