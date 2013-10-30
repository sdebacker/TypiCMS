<?php namespace TypiCMS\Services\Form\Page;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class PageFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'fr.slug' => 'required_with:fr.title',
		'nl.slug' => 'required_with:nl.title',
		'en.slug' => 'required_with:en.title',
	);

}