<?php
namespace TypiCMS\Modules\Menulinks\Services\Form;

use TypiCMS\Services\Form\AbstractForm;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface;

class MenulinkForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, MenulinkInterface $menulink)
    {
        $this->validator = $validator;
        $this->repository = $menulink;
    }
}
