<?php
namespace TypiCMS\Modules\Groups\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class GroupFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'name' => 'required|min:4|unique:groups'
    );

    /**
     * Custom Validation Messages
     *
     * @var Array
     */
    protected $messages = array(
        //'email.required' => 'An email address is required.'
    );
}
