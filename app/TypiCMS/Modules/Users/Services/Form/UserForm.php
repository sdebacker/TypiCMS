<?php
namespace TypiCMS\Modules\Users\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Users\Repositories\UserInterface;

class UserForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, UserInterface $user)
    {
        $this->validator = $validator;
        $this->repository = $user;
    }

    /**
     * Update an existing user
     *
     * @return boolean
     */
    public function update(array $input)
    {
        $this->validator->setRule('email', 'required|email|unique:users,email,'.$input['id']);
        $this->validator->setRule('password', 'min:8|confirmed');
        $this->validator->setRule('password_confirmation', '');

        if (! $this->valid($input)) {
            return false;
        }

        return $this->repository->update($input);
    }

    /**
     * Test if form validator passes
     *
     * @return boolean
     */
    public function resetPasswordValid(array $input)
    {
        $this->validator->emptyRules()->setRule('email', 'required|email');

        return $this->valid($input);
    }

    /**
     * Test if form validator passes
     *
     * @return boolean
     */
    public function changePasswordValid(array $input)
    {
        $this->validator->emptyRules()->setRule('password', 'required|min:8|confirmed');

        return $this->valid($input);
    }
}
