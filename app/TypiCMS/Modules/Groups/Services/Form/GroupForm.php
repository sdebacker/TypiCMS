<?php
namespace TypiCMS\Modules\Groups\Services\Form;

use TypiCMS\Services\Form\AbstractForm;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Groups\Repositories\GroupInterface;

class GroupForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, GroupInterface $group)
    {
        $this->validator = $validator;
        $this->repository = $group;
    }
}
