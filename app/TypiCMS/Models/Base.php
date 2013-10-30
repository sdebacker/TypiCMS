<?php namespace TypiCMS\Models;

use Eloquent;

abstract class Base extends Eloquent {


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