<?php namespace Way\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Way\Helpers\File as FileHelpers;
use Way\Helpers\Helpers as Helpers;

class FileNotFoundException extends \Exception {}

class Guardfile {

	/**
	 * Filesystem Instance
	 *
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $file;

	/**
	 * Config Instance
	 *
	 * @var Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Base path to where Guardfile is store
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Constructor
	 *
	 * @param  Filesystem $file
	 * @param  string $path
	 * @return void
	 */
	public function __construct(Filesystem $file, Config $config, $path = null)
	{
		$this->file = $file;
		$this->config = $config;
		$this->path = $path ?: base_path();
	}

	/**
	 * Get the path to the Guardfile
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path.'/Guardfile';
	}

	/**
	 * Get contents of Guardfile
	 *
	 * @return string
	 */
	public function getContents()
	{
		return $this->file->get($this->getPath());
	}

	/**
	 * Update contents of Guardfile
	 *
	 * @param string $contents
	 * @return void
	 */
	public function put($contents)
	{
		$this->file->put($this->getPath(), $contents);
	}

	/**
	 * Get a guard configuration option
	 *
	 * @param  string $option
	 * @return mixed
	 */
	public function getConfigOption($option)
	{
		return $this->config->get("guard-laravel::guard.{$option}");
	}

	/**
	 * Get stubs for requested plugins
	 *
	 * @param  array  $plugins
	 * @return string
	 */
	public function getStubs(array $plugins)
	{
		$stubs = array();

		foreach($plugins as $plugin)
		{
			$stubs[] = $this->compile($this->getPluginStub($plugin), $plugin);
		}

	    // Now, we'll stitch them all together
		return implode("\n\n", $stubs);
	}

	/**
	 * Gets the stub for a Guard plugin
	 *
	 * @param  string $plugin
	 * @return string
	 */
	public function getPluginStub($plugin)
	{
		$stubPath = __DIR__ . "/stubs/guard-{$plugin}-stub.txt";

		if ($this->file->exists($stubPath))
		{
			return $this->file->get($stubPath);
		}

		throw new FileNotFoundException('Plugin name or stub not recognized');
	}

	/**
	 * Perform search and replace on stub
	 * with data from user config
	 *
	 * @param  string $stub
	 * @param  string $plugin
	 * @return string
	 */
	public function compile($stub, $plugin)
	{
		$stub = $this->applyPathsToStub($stub);
		$stub = $this->applyOptions($stub, $plugin);

		// If we're updating the concat guard plugin,
		// then we need to update the file list, too
		if (starts_with($plugin, 'concat'))
		{
			$stub = $this->applyFileList($stub, substr($plugin, 7));
		}

		return $stub;
	}

	/**
	 * Replace template tags in stub
	 *
	 * @param  string $stub
	 * @return string
	 */
	public function applyPathsToStub($stub)
	{
		$self = $this; // 5.3 support :(

		return preg_replace_callback('/{{([a-z]+?)Path}}/i', function($matches) use($self) {
			$language = $matches[1];

			return $self->getConfigOption("{$language}_path");
		}, $stub);
	}

	/**
	 * Set options for guard plugin
	 *
	 * @param  string $stub
	 * @param string $plugin
	 * @return string
	 */
	protected function applyOptions($stub, $plugin)
	{
		$pluginOptions = $this->getConfigOption("guard_options.{$plugin}");

		// If options have been set for this guard
		// then format them as Ruby, and search+replace
		if (! empty($pluginOptions))
		{
			$rubyFormattedOptions = Helpers::arrayToRuby($pluginOptions);
			$stub = str_replace('{{options}}', ', ' . implode(', ', $rubyFormattedOptions), $stub);
		}

		// Otherwise, no options specified.
		$stub = str_replace('{{options}}', '', $stub);

		return $stub;
	}

	/**
	 * Replace stub with updated file list
	 *
	 * @param  string $stub
	 * @param string language [css|js]
	 * @return string
	 */
	protected function applyFileList($stub, $language)
	{
		$files = $this->getFilesToConcat($language);

		return str_replace('{{files}}', implode(' ', $files), $stub);
	}

	/**
	 * Update plugin signature and save file
	 *
	 * @param  string $plugin
	 * @return void
	 */
	public function updateSignature($plugin)
	{
		$stub = $this->compile($this->getPluginStub($plugin), $plugin);

		// Concat plugins need special search+replace.
		if (starts_with($plugin, 'concat'))
		{
			$language = substr($plugin, 7);
			$stub = preg_replace('/guard :concat, :type => "' . $language . '".+/i', $stub, $this->getContents());
		}
		else
		{
			$module = $plugin === 'refresher' ? '(module.+?)?' : '';
			$stub = preg_replace("/{$module}guard :" . $plugin . ".+?(?=\\n\\n|$)/us", $stub, $this->getContents());
		}

		$this->put($stub);
	}

	/**
	 * Get list of files to concat
	 *
	 * @param  string $language
	 * @return string
	 */
	public function getFilesToConcat($language)
	{
		$files = $this->getConfigOption("{$language}_concat");

		return FileHelpers::removeExtensions(FileHelpers::deleteMinified($files));
	}

}