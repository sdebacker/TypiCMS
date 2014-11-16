<?php
namespace TypiCMS\Modules\Places\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class PlaceFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'fr.slug'     => 'required_with:fr.title|required_if:fr.status,1|alpha_dash',
        'nl.slug'     => 'required_with:nl.title|required_if:nl.status,1|alpha_dash',
        'en.slug'     => 'required_with:en.title|required_if:en.status,1|alpha_dash',
        'email'       => 'email',
        'website'     => 'url',
        'image'       => 'image|max:2000|image_size:>=500',
    );
}
