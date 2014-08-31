<?php
namespace TypiCMS\Modules\Partners\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Partners\Repositories\PartnerInterface;

class PartnerForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, PartnerInterface $partner)
    {
        $this->validator = $validator;
        $this->repository = $partner;
    }
}
