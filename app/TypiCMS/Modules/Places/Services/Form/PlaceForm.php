<?php
namespace TypiCMS\Modules\Places\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;

class PlaceForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, PlaceInterface $place)
    {
        $this->validator = $validator;
        $this->repository = $place;
    }
}
