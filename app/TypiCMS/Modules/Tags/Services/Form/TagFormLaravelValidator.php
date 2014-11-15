<?php
namespace TypiCMS\Modules\Tags\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class TagFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'tag'  => 'required',
        'slug' => 'required|alpha_dash',
    );
}
