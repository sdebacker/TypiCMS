<?php namespace Ink\InkTranslatable\Models;

use Illuminate\Support\Facades\Config;

abstract class EloquentTranslatable extends \Eloquent {
	
    /**
     * Translations by $locale
     *
     * @param  string $locale
	 * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations($locale = '')
    {
		if ( !$locale ) $locale = Config::get('app.locale');
		
        return $this->_translations()->where($this->getLocaleField(), '=', $locale);
    }

    /**
     * Translations
	 * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function _translations()
	{
		return $this->hasMany($this->getTranslationModel(), $this->getRelationshipField());
	}

    /**
     * Magic get
	 * 
	 * @param  string  $key
	 *
     * @return mixed
     */
	public function __get($key)
	{
		$locales = Config::get('app.locales');
		
		if ( in_array($key, $locales) ) 
		{
			return $this->translations($key)->first();
		}
		
        if ( in_array($key, $this->getTranslatableFields()))
		{
			return $this->translations->first()->{$key};
		}
		
		return parent::__get($key);
	}

    /**
     * Delete translations
	 * 
     * @return boolean|null
     */	
	public function delete()
	{
		$this->_translations()->delete();
		return parent::delete();
	}

    /**
     * @return string
     */
    private function getLocaleField()
    {
        return isset(static::$translatable['localeField'])
            ? static::$translatable['localeField']
            : 'lang';
    }

    /**
     * @return string
     */
    private function getTranslationModel()
    {
        return isset(static::$translatable['translationModel'])
            ? static::$translatable['translationModel']
            : get_called_class().'Translation';
    }

    /**
     * @return string
     */
    private function getRelationshipField()
    {
        return isset(static::$translatable['relationshipField'])
            ? static::$translatable['relationshipField']
            : snake_case(get_called_class()).'_id';
    }

    /**
     * @return array
     */
    private function getTranslatableFields()
    {
        return isset(static::$translatable['translatables'])
            ? (array) static::$translatable['translatables']
            : (array) static::$translatables;
    }
}
