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

    /**
     * Create a new page
     *
     * @return boolean
     */
    public function save(array $input)
    {
        $inputDot = array_dot($input);

        if (! $this->valid($inputDot)) {
            return false;
        }

        $input['tags'] = $this->processTags($input['tags']);

        return $this->repository->create($input);
    }

    /**
     * Update an existing project
     *
     * @return boolean
     */
    public function update(array $input)
    {
        $inputDot = array_dot($input);
        if (! $this->valid($inputDot)) {
            return false;
        }

        $input['tags'] = $this->processTags($input['tags']);

        return $this->repository->update($input);
    }
}
