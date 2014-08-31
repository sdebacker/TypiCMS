<?php
namespace TypiCMS\Modules\Categories\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;

class CategoryForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, CategoryInterface $category)
    {
        $this->validator = $validator;
        $this->repository = $category;
    }
}
