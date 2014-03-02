<?php namespace TypiCMS\Modules\Translations\Loaders;

use Illuminate\Translation\LoaderInterface;

class Loader implements LoaderInterface {

	/**
	 * All of the namespace hints.
	 *
	 * @var array
	 */
	protected $hints = array();

	/**
	 * Load the messages for the given locale.
	 *
	 * @param  string  $locale
	 * @param  string  $group
	 * @param  string  $namespace
	 * @return array
	 */
	public function load($locale, $group, $namespace = null)
	{
		return $this->loadRaw($locale, $group, $namespace);
	}

	/**
	 * Load the messages for the given locale without checking the cache or in case of a cache miss. Merge with the default locale messages.
	 *
	 * @param  string  $locale
	 * @param  string  $group
	 * @param  string  $namespace
	 * @return array
	 */
	public function loadRaw($locale, $group, $namespace = null)
	{
		return array();
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