<?php
namespace TypiCMS\Modules\Menus\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class MenuFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'name' => 'required|alpha_dash|unique:menus',
    );
}
