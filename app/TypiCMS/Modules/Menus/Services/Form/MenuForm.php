<?php
namespace TypiCMS\Modules\Menus\Services\Form;

use TypiCMS\Services\Form\AbstractForm;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Menus\Repositories\MenuInterface;

class MenuForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, MenuInterface $menu)
    {
        $this->validator = $validator;
        $this->repository = $menu;
    }
}
