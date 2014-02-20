<?php namespace TypiCMS\Models;

use App;
use Mockery;
use Eloquent;

abstract class Base extends Eloquent {

	/**
	 * For testing
	 */	
	public static function shouldReceive()
	{
		$classArray = explode('\\', get_called_class());
		$class = end($classArray);
		$repo = 'TypiCMS\\Modules\\'.str_plural($class).'\\Repositories\\'.$class.'Interface';
		$mock = Mockery::mock($repo);

		App::instance($repo, $mock);

		return call_user_func_array(array($mock, 'shouldReceive'), func_get_args());
	}

}