<?php namespace TypiCMS\Modules\Events\Services\Form;

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
		'fr.slug' => 'required_with:fr.title|required_with:fr.status|alpha_dash',
		'nl.slug' => 'required_with:nl.title|required_with:nl.status|alpha_dash',
		'en.slug' => 'required_with:en.title|required_with:en.status|alpha_dash',
	);

}