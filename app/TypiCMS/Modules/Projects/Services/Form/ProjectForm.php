<?php
namespace TypiCMS\Modules\Projects\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface;

class ProjectForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, ProjectInterface $project)
    {
        $this->validator = $validator;
        $this->repository = $project;
    }
}
