<?php
namespace TypiCMS\Modules\Menulinks\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class MenulinkFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'fr.url'   => 'url',
        'en.url'   => 'url',
        'nl.url'   => 'url',
        'menu_id'  => 'required',
    );
}
