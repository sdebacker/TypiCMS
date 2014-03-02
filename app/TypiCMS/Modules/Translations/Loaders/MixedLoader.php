<?php namespace TypiCMS\Modules\Translations\Loaders;

use Illuminate\Translation\FileLoader;
use Illuminate\Translation\LoaderInterface;

class MixedLoader extends Loader implements LoaderInterface {

	/**
	 *	The file loader.
	 *	@var \Illuminate\Translation\FileLoader
	 */
	protected $fileLoader;

	/**
	 *	The database loader.
	 *	@var \TypiCMS\Modules\Translations\Loaders\DatabaseLoader
	 */
	protected $databaseLoader;

	/**
	 * 	Create a new mixed loader instance.
	 *
	 *	@return TypiCMS\Modules\Translations\Repositories\TranslationInterface $repository
	 *	@param 	\Illuminate\Foundation\Application $app
	 */
	public function __construct($fileLoader, $databaseLoader)
	{
		$this->fileLoader     = $fileLoader;
		$this->databaseLoader = $databaseLoader;
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
		$namespace = $namespace ?: '*';
		return array_merge($this->databaseLoader->load($locale, $group, $namespace), $this->fileLoader->load($locale, $group, $namespace));
	}
}