<?php namespace TypiCMS\Models;

use Illuminate\Support\Facades\Config;

abstract class EloquentTranslatable extends Base {

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
        
        if ( in_array($key, $this->getTranslatableFields()) and $this->translations->first())
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
        return isset(static::$translatable) && isset(static::$translatable['localeField'])
            ? static::$translatable['localeField']
            : 'lang';
    }

    /**
     * @return string
     */
    private function getTranslationModel()
    {
        return isset(static::$translatable) && isset(static::$translatable['translationModel'])
            ? static::$translatable['translationModel']
            : get_called_class().'Translation';
    }

    /**
     * @return string
     */
    private function getRelationshipField()
    {
        $called_class = explode('\\', get_called_class());
        $called_class = end($called_class);
        return isset(static::$translatable) && isset(static::$translatable['relationshipField'])
            ? static::$translatable['relationshipField']
            : snake_case($called_class).'_id';
    }

    /**
     * @return array
     */
    private function getTranslatableFields()
    {
        return isset(static::$translatable) && isset(static::$translatable['translatables'])
            ? (array) static::$translatable['translatables']
            : (array) static::$translatables;
    }

    // joindre toutes les traductions sans where lang
    public function scopeJoinTranslations($query, $lang = null)
    {
        return $query->with('translations')->leftJoin(
            $this->table.'_translations', function($join) use ($lang)
            {
                $join->on($this->table.'.id', '=', $this->table.'_translations.'.$this->getRelationshipField());
                if ($lang) {
                    $join->where($this->table.'_translations.lang', '=', $lang);
                }
            }
        );
    }


    /**
     * Add translatable fields to model, so Former can populate
     */
    public function setTranslatedFields()
    {
        $locales = Config::get('app.locales');
        foreach ($locales as $lang) {
            $translation = $this->$lang;
            $fields = array();
            foreach ($this->getTranslatableFields() as $field) {
                if (isset($translation->$field)) {
                    $fields[$field] = $translation->$field;
                } else {
                    $fields[$field] = '';
                }
            }
            $this->$lang = $fields;
        }
    }

}
