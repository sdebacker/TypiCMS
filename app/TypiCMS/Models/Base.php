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

	public function scopeFiles($query, $all = false)
	{
		return $query->with(array('files' => function($query) use ($all)
			{
				$query->with(array('translations' => function($query) use ($all)
				{
					$query->where('locale', App::getLocale());
					! $all and $query->where('status', 1);
				}));
				$query->whereHas('translations', function($query) use ($all)
				{
					$query->where('locale', App::getLocale());
					! $all and $query->where('status', 1);
				});
				$query->orderBy('position', 'asc');
			})
		);
	}

}