<?php namespace Way\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GuardWatchCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'guard:watch';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Begin watching files';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		shell_exec('guard'); // ...I know. Convenience, fool!
	}

}