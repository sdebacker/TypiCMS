<?php namespace TypiCMS\Modules\Places\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class PlaceFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'title'       => 'required',
		'slug'        => 'required_with:title|alpha_dash',
		'email'       => 'email',
		'website'     => 'url',
		'logo'        => 'image|max:500',
		'image'       => 'image|max:2000',
	);

}