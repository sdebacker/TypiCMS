<?php
namespace TypiCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Install extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cms:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Installation of TypiCMS: initial Laravel setup, composer, bower, npm';

	/**
	 * Create a new key generator command.
	 *
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 * @return void
	 */
	public function __construct(Filesystem $files)
	{
		parent::__construct();

		$this->files = $files;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->checkThatEnvironmentIsLocal();
		$this->checkThatEnvTemplateExists();

		$this->line('Welcome to TypiCMS');

		// Generate Laravel encryption key
		$this->call('key:generate');

		// Ask for database name
		$dbName = $this->ask('What is your database name? ');

		// Set database credentials in env.local.php and migrate
		$this->call('cms:database', array('database' => $dbName));

		// Set cache key prefix
		$this->call('cms:cacheprefix', array('prefix' => $dbName));

		// Composer install
		if (function_exists('system')) {
			system('composer install');
			system('npm install');
			system('bower install');
		} else {
			$this->info('you can now run composer install, npm install and bower install');
		}
		
	}

	/**
	 * Installation is only possible when environment is local
	 * 
	 * @return void      exit if env is not local
	 */
	public function checkThatEnvironmentIsLocal()
	{
		if (! $this->laravel->environment('local')) {
			$this->error('Installation is only possible when environment is local.');
			exit();
		}
	}

	/**
	 * Check that env.local.php exists
	 * 
	 * @return void      exit if env.local.php is not found
	 */
	public function checkThatEnvTemplateExists()
	{
		if (! $this->files->exists('env.local.php')) {
			$this->error('No env.local.php template found.');
			exit();
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
