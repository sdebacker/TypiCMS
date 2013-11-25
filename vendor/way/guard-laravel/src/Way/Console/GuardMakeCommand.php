<?php namespace Way\Console;


use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;

class GuardMakeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'guard:make';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Make a new Guardfile';

	/**
	 * List of desired Guard plugins,
	 * including default plugins
	 *
	 * @var array
	 */
	protected $plugins = array('concat-js', 'concat-css', 'refresher', 'phpunit', 'livereload');

	/**
	 * File generator instance
	 *
	 * @var GuardGenerator
	 */
	protected $generate = array();

	/**
	 * Gem builder
	 *
	 * @var Way\Console\Gem
	 */
	protected $gem;

	/**
	 * Path to assets directory
	 *
	 * @var string
	 */
	protected $assetsPath;

	/**
	 * Create a new command instance.
	 *
	 * @param GuardGenerator $generate
	 * @param Gem $gem
	 * @param Config $config
	 * @return void
	 */
	public function __construct(GuardGenerator $generate, Gem $gem, Config $config)
	{
		parent::__construct();

		$this->generate = $generate;
		$this->gem = $gem;
		$this->assetsPath = $config->get("guard-laravel::guard.assets_path");
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if (! $this->hasRuby())
		{
			$this->error('Please install Ruby and RubyGems.');
			exit();
		}

		$this->getDefaultGems();

		// Do they want preprocessing?
		if ($preprocessor = $this->wantsPreprocessing())
		{
			$this->setupPreprocessor($preprocessor);
		}

		// Do they want CoffeeScript?
		if ($this->wantsCoffee())
		{
			$this->setupPreprocessor('coffeescript', 'coffee');
		}

		$this->generate->guardFile($this->plugins);
		$this->generate->log($this->plugins);
		$this->info('Created Guardfile');
	}

	/**
	 * Does user have Ruby installed?
	 *
	 * @return boolean
	 */
	protected function hasRuby()
	{
		$ruby = shell_exec('ruby -v');

		return starts_with($ruby, 'ruby');
	}

	/**
	 * Install default gems
	 *
	 * @return void
	 */
	protected function getDefaultGems()
	{
		$this->info('Ensuring that you have all required plugins...');

		$requiredGems = array(
			'guard', 'guard-livereload',
			'guard-phpunit','guard-concat',
			'jsmin', 'cssmin'
		);

		foreach($requiredGems as $gem)
		{
			$this->getGem($gem);
		}
	}

	/**
	 * Install gem
	 *
	 * @param  string $gemName
	 * @return void
	 */
	protected function getGem($gemName)
	{
		if (! $this->gem->exists($gemName))
		{
			$this->info("Installing $gemName...");
			$this->gem->install($gemName);
			$this->info("The {$gemName} gem has been installed.");
		}
	}

	/**
	 * Ask if user wants a CSS preprocessor
	 *
	 * @return string|boolean
	 */
	protected function wantsPreprocessing()
	{
		if ($this->confirm('Do you require CSS preprocessing? [yes|no]', false))
		{
			$preprocessor = strtolower($this->ask('Which CSS preprocessor do you want? [sass|less]'));

			while (! $preprocessor or ! in_array($preprocessor, array('sass', 'less')))
			{
				// ask again
				$preprocessor = $this->ask('I did not recognize that preprocessor. Please try again. [sass|less]');
			}

			return $preprocessor;
		}

		return false;
	}

	/**
	 * Ask if the user wants CoffeeScript
	 *
	 * @return boolean
	 */
	protected function wantsCoffee()
	{
		return $this->confirm('What about CoffeeScript support? [yes|no]', false);
	}

	/**
	 * Get the preprocessor Gem if needed
	 * and created the asset folder.
	 *
	 * @param  string $preprocessor
	 * @return void
	 */
	protected function setupPreprocessor($preprocessor, $dirName = null)
	{
		$dirName = $dirName ?: $preprocessor;

		// We need to keep track of which plugins
		// have been requested.
		$this->plugins[] = $preprocessor;

		$this->getGem("guard-{$preprocessor}");
		$this->generate->folder("{$this->assetsPath}/{$dirName}");
		$this->info("Created {$this->assetsPath}/{$dirName}");
	}

}