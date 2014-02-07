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
		$classArray = explode('\\', get_called_class());
		$class = end($classArray);
		$repo = 'TypiCMS\\Repositories\\'.$class.'\\'.$class.'Interface';
		$mock = Mockery::mock($repo);

		App::instance($repo, $mock);

		return call_user_func_array([$mock, 'shouldReceive'], func_get_args());
	}


	public function scopeOrder($query)
	{
		return $query->orderBy(static::$order, static::$direction);
	}


	/**
	 * Désactiver scopeTranslations
	 */
	public function scopeTranslations($query)
	{
		return $query;
	}


	/**
	 * Désactiver setTranslatedFields
	 */
	public function setTranslatedFields()
	{
		return;
	}


	/**
	 * Renvoie la direction du modèle ou sa direction inverse
	 *
	 * @param string $sens : '' ou 'inverse'
	 * @return string 'asc' or 'desc'
	 */
	public static function direction($sens = '')
	{
		if ($sens == 'inverse') {
			return (static::$direction == 'asc') ? 'desc' : 'asc' ;
		}
		return static::$direction;
	}


}