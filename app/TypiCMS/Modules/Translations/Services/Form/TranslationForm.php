<?php
namespace TypiCMS\Modules\Translations\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Translations\Repositories\TranslationInterface;

class TranslationForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, TranslationInterface $translation)
    {
        $this->validator = $validator;
        $this->repository = $translation;
    }
}
