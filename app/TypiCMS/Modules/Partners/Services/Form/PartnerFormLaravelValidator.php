<?php
namespace TypiCMS\Modules\Partners\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class PartnerFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'fr.slug'        => 'required_with:fr.title|required_if:fr.status,1|alpha_dash',
        'nl.slug'        => 'required_with:nl.title|required_if:nl.status,1|alpha_dash',
        'en.slug'        => 'required_with:en.title|required_if:en.status,1|alpha_dash',
        'fr.website'     => 'url',
        'nl.website'     => 'url',
        'en.website'     => 'url',
        'position'       => 'required|integer|min:1',
        'logo'           => 'image|image_aspect:1|image_size:>=200,>=200|max:2000',
    );
}
