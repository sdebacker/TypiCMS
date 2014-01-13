<?php namespace TypiCMS\Services\Form\News;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class NewsFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'date' => 'required|date|date_format:d.m.Y H:i',
		'fr.slug' => 'required_with:fr.title|alpha_dash',
		'nl.slug' => 'required_with:nl.title|alpha_dash',
		'en.slug' => 'required_with:en.title|alpha_dash',
	);

}