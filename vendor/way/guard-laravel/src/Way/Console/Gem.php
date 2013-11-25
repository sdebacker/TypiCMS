<?php namespace Way\Console;

class Gem {

	/**
	 * Install gem if it doesn't exist
	 *
	 * @param  string $gemName
	 * @return void
	 */
	public function mustBeAvailable($gemName)
	{
		if (! $this->exists($gemName))
		{
			$this->install($gemName);
		}
	}

	/**
	 * Determines if gem exists
	 *
	 * @param  string $name
	 * @return boolean
	 */
	public function exists($name)
	{
		return ! is_null(shell_exec("gem spec $name 2>/dev/null"));
	}

	/**
	 * Installs gem
	 * @param  string $name
	 * @return void
	 */
	public function install($name)
	{
		shell_exec("gem install $name");
	}

}