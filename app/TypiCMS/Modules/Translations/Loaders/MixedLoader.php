<?php namespace TypiCMS\Modules\Translations\Loaders;

use Illuminate\Translation\LoaderInterface;

class MixedLoader implements LoaderInterface {

	/**
	 *	The file loader.
	 *	@var \Illuminate\Translation\FileLoader
	 */
	protected $fileLoader;

	/**
	 *	Repository.
	 *	@var \TypiCMS\Modules\Translations\Repositories\TranslationInterface
	 */
	protected $repository;

	/**
	 * 	Create a new mixed loader instance.
	 *
	 *	@param 	\Illuminate\Translation\FileLoader $fileLoader
	 *	@param 	\TypiCMS\Modules\Translations\Repositories\TranslationInterface $repository
	 */
	public function __construct($fileLoader, $repository)
	{
		$this->fileLoader     = $fileLoader;
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
	public function load($locale, $group, $namespace = null)
	{
		$namespace = $namespace ?: '*';
		return array_merge($this->loadFromDB($locale, $group, $namespace), $this->fileLoader->load($locale, $group, $namespace));
	}


	/**
	 * Load the messages from DB strictly for the given locale.
	 *
	 * @param  Language  	$language
	 * @param  string  		$group
	 * @param  string  		$namespace
	 * @return array
	 */
	public function loadFromDB($locale, $group, $namespace = null)
	{
		return $this->repository->getAllToArray($locale, $group, $namespace);
	}


	/**
	 * Add a new namespace to the loader.
	 *
	 * @param  string  $namespace
	 * @param  string  $hint
	 * @return void
	 */
	public function addNamespace($namespace, $hint)
	{
		$this->hints[$namespace] = $hint;
		$this->fileLoader->addNamespace($namespace, $hint);
	}

}