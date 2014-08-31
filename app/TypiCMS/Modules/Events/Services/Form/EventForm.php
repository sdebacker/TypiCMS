<?php
namespace TypiCMS\Modules\Events\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Events\Repositories\EventInterface;

class EventForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, EventInterface $event)
    {
        $this->validator = $validator;
        $this->repository = $event;
    }
}
