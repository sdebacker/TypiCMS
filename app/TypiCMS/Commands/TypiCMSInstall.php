<?php
namespace TypiCMS\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TypiCMSInstall extends Command {

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
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Welcome to TypiCMS');
		$dbName = $this->ask('What is your database name?');
		$dbPassword = $this->secret('What is your database password?');
		$this->call('key:generate');
		$this->call('migrate');
		$this->call('cms:cacheprefix', array('prefix' => $dbName));
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
