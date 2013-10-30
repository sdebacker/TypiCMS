<?php namespace Basset\Factory;

use Illuminate\Support\Manager;

class FactoryManager extends Manager {

	/**
	 * Get a registered factory driver.
	 * 
	 * @param  string  $factory
	 * @return \Basset\Factory\Factory
	 */
	public function get($factory = null)
	{
		return $this->driver($factory);
	}

	/**
	 * Create the asset factory driver.
	 * 
	 * @return \Basset\Factory\AssetFactory
	 */
	public function createAssetDriver()
	{
		$asset = new AssetFactory($this->app['files'], $this->app['env'], $this->app['path.public']);

		return $this->factory($asset);
	}

	/**
	 * Create the filter factory driver.
	 * 
	 * @return \Basset\Factory\FilterFactory
	 */
	public function createFilterDriver()
	{
		$aliases = $this->app['config']->get('basset::aliases.filters', array());

		$node = $this->app['config']->get('basset::node_paths', array());

		$filter = new FilterFactory($aliases, $node, $this->app['env']);

		return $this->factory($filter);
	}

	/**
	 * Set the logger and factory manager on the factory instance.
	 * 
	 * @param  \Basset\Factory\Factory  $factory
	 * @return \Basset\Factory\Factory
	 */
	protected function factory(Factory $factory)
	{
		$factory->setLogger($this->getLogger());

		return $factory->setFactoryManager($this);
	}

	/**
	 * Get the log writer instance.
	 * 
	 * @return \Illuminate\Log\Writer
	 */
	public function getLogger()
	{
		return $this->app['basset.log'];
	}

}