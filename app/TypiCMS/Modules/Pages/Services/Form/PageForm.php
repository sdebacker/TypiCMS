<?php
namespace TypiCMS\Modules\Pages\Services\Form;

use TypiCMS\Services\Form\AbstractForm;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Pages\Repositories\PageInterface;

class PageForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, PageInterface $page)
    {
        $this->validator = $validator;
        $this->repository = $page;
    }
}
