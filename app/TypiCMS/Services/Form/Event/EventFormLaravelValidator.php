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
		'fr.slug' => 'required_with:fr.title',
		'nl.slug' => 'required_with:nl.title',
		'en.slug' => 'required_with:en.title',
	);

}