<?php namespace Way\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GuardRefreshCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'guard:refresh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh the Guardfile';

	/**
	 * Guard
	 *
	 * @var Way\Console\Guardfile
	 */
	protected $guardFile;

	/**
	 * Plugins that require refreshing
	 *
	 * @var array
	 */
	protected $refreshable = array(
		'concat-css',
		'concat-js',
		'coffeescript',
		'sass',
		'less',
		'uglify',
		'refresher'
	);

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(GuardFile $guardFile)
	{
		parent::__construct();

		$this->guardFile = $guardFile;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// We'll fetch a list of the user's requested plugins,
		// but only the ones that require refreshing.
		$plugins = array_intersect($this->getPluginLog(), $this->refreshable);

		foreach($plugins as $plugin)
		{
			$this->guardFile->updateSignature($plugin);
		}
	}

	/**
	 * Get the log of plugins from guard:make
	 *
	 * @param  string $path
	 * @return array
	 */
	protected function getPluginLog($path = null)
	{
		$path = $path ?: app_path().'/storage/guard/plugins.txt';

		return json_decode(\File::get($path));
	}

}