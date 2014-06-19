<?php
namespace TypiCMS\Modules\Blocks\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class BlockFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'name' => 'required|alpha_dash|unique:blocks',
    );
}
