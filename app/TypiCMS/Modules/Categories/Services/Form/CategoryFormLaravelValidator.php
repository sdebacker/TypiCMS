<?php namespace TypiCMS\Modules\Categories\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class CategoryFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'fr.slug' => 'required_with:fr.title|required_with:fr.status|alpha_dash',
        'nl.slug' => 'required_with:nl.title|required_with:nl.status|alpha_dash',
        'en.slug' => 'required_with:en.title|required_with:en.status|alpha_dash',
    );

}