<?php namespace Ink\InkTranslatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Translatable {

    /**
     * The locales array
     *
     * @var array
     */
    protected $locales = array();

    /**
     * Constructor
     *
     * @param array $config
     * @param array $locales
     */
    public function __construct( array $locales ) {
        $this->locales = $locales;
    }

    /**
     * Translate model
     *
     * @param  Model     $model The model
	 *
     * @return boolean
     */
    public function translate( Model $model, $inputs = array() )
    {
        // if the model isn't translatable, then do nothing
        if ( !isset( $model::$translatable ) )
            return true;

        // nicer variables for readability
        $translationModel = $relationshipField = $localeField = $translatables = null;
        extract( $model::$translatable, EXTR_IF_EXISTS );
		
        // POST parameters
        if ( sizeof($inputs) == 0 ) $inputs = Input::all();

        // iterating locales
        foreach($this->locales as $locale)
        {
            // if $locale exists in POST parameters
            if ( array_key_exists($locale, $inputs) )
            {

                // get translatable fields from POST parameters
                $translatables = $inputs[$locale];

		        if ( !$translatables )
		            return true;

                // get translation from model if it exists
                $record = $translationModel::where( $relationshipField, '=', $model->id )
                    ->where( $localeField, '=', $locale )
					->first();

                // if translation not exists, create a new translation
                if ( !$record )
                {
                    $translatables[$localeField]       = $locale;
                    $translatables[$relationshipField] = $model->id;

                    $record = new $translationModel;
                }
					
                // add values to translation
                foreach ($inputs[$locale] as $field => $value)
				{
					if ( !in_array($field, $model::$translatable['translatables']) ) return true;
                }
					
                // add values to translation
                foreach ($translatables as $field => $value)
				{
                    $record->$field = $value;
                }

                // save
                $record->save();

            }
        }

        // done!
        return true;
    }
}