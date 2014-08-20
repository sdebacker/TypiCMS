<?php
namespace TypiCMS\Modules\Files\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class FileFormLaravelValidator extends AbstractLaravelValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'file' => 'mimes:jpeg,gif,png,pdf,rtf,txt,md,doc,xls,ppt,docx,xlsx,ppsx,pptx,sldx|max:2000',
    );
}
