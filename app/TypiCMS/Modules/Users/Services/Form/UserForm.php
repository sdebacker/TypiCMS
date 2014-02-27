<?php namespace TypiCMS\Modules\Users\Services\Form;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Users\Repositories\UserInterface;

class UserForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \TypiCMS\Services\Validation\ValidableInterface
	 */
	protected $validator;

	/**
	 * User repository
	 *
	 * @var \TypiCMS\Modules\Users\Repositories\UserInterface
	 */
	protected $user;

	public function __construct(ValidableInterface $validator, UserInterface $user)
	{
		$this->validator = $validator;
		$this->user = $user;
	}

	/**
	 * Create a new user
	 *
	 * @return boolean
	 */
	public function save(array $input)
	{
		
		if( ! $this->valid($input) ) {
			return false;
		}

		return $this->user->create($input);
	}

	/**
	 * Update an existing user
	 *
	 * @return boolean
	 */
	public function update(array $input)
	{		
		$this->validator->setRule('email', 'required|email|unique:users,email,'.$input['id']);
		$this->validator->setRule('password', 'min:8');
		$this->validator->setRule('password_confirmation', '');

		if( ! $this->valid($input) ) {
			return false;
		}

		return $this->user->update($input);
	}

	/**
	 * Return any validation errors
	 *
	 * @return array
	 */
	public function errors()
	{
		return $this->validator->errors();
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

	/**
	 * Test if form validator passes
	 *
	 * @return boolean
	 */
	public function valid(array $input)
	{
		return $this->validator->with($input)->passes();
	}

}