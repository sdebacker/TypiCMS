<?php
namespace TypiCMS\Modules\Users\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class UserFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'email' => 'required|email|unique:users',
        'first_name' => 'required',
        'last_name' => 'required',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required'
    );
}
