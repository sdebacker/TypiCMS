<?php
namespace TypiCMS\Modules\Contacts\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class ContactFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'email'      => 'required|email',
        'title'      => 'required',
        'first_name' => 'required',
        'last_name'  => 'required',
        'message'    => 'required',
        'website'    => 'url',
        'my_name'    => 'honeypot',
        'my_time'    => 'required|honeytime:5',
    );
}
