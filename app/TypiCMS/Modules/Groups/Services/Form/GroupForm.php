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

    /**
     * Update an existing user
     *
     * @return boolean
     */
    public function update(array $input)
    {
        $this->validator->setRule('name', 'required|min:4|unique:groups,name,'.$input['id']);

        if (! $this->valid($input)) {
            return false;
        }

        return $this->repository->update($input);
    }
}
