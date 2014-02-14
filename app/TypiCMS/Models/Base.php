<?php namespace TypiCMS\Models;

use Eloquent;
use Mockery;
use App;

abstract class Base extends Eloquent {

	/**
	 * For testing
	 */	
	public static function shouldReceive()
	{
		var_dump(get_called_class());
		$classArray = explode('\\', get_called_class());
		$class = end($classArray);
		$repo = 'TypiCMS\\Modules\\'.str_plural($class).'\\Repositories\\'.$class.'Interface';
		$mock = Mockery::mock($repo);

		App::instance($repo, $mock);

		return call_user_func_array([$mock, 'shouldReceive'], func_get_args());
	}

}