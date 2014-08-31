<?php
namespace TypiCMS\Modules\Tags\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Tags\Repositories\TagInterface;

class TagForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, TagInterface $tag)
    {
        $this->validator = $validator;
        $this->repository = $tag;
    }
}
