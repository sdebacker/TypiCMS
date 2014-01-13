<?php namespace TypiCMS\Services\Form\Event;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class EventFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'start_date' => 'required|date|date_format:d.m.Y',
		'end_date' => 'date|date_format:d.m.Y',
		'fr.slug' => 'required_with:fr.title|alpha_dash',
		'nl.slug' => 'required_with:nl.title|alpha_dash',
		'en.slug' => 'required_with:en.title|alpha_dash',
	);

}