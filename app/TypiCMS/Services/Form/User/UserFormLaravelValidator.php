<?php namespace TypiCMS\Services\Form\User;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class UserFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'email' => 'required|email|unique:users',
		'first_name' => 'required',
		'last_name' => 'required',
		'password' => 'required|min:8|confirmed',
		'password_confirmation' => 'required'
	);
	
	public function getRules()
	{
		return $this->rules;
	}

	public function setRule($key, $value)
	{
		$this->rules[$key] = $value;
		return $this;
	}

	public function emptyRules()
	{
		$this->rules = array();
		return $this;
	}

}