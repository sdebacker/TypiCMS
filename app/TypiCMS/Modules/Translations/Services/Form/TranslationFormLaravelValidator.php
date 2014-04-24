<?php
namespace TypiCMS\Modules\Translations\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class TranslationFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'key' => 'required',
    );
}
