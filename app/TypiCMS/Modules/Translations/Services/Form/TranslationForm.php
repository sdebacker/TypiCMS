<?php namespace TypiCMS\Modules\Translations\Services\Form;

use Input;
use Config;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Translations\Repositories\TranslationInterface;

class TranslationForm {

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
	 * Translation repository
	 *
	 * @var \TypiCMS\Modules\Translations\Repositories\TranslationInterface
	 */
	protected $translation;

	public function __construct(ValidableInterface $validator, TranslationInterface $translation)
	{
		$this->validator = $validator;
		$this->translation = $translation;
	}

	/**
	 * Create a new page
	 *
	 * @return boolean
	 */
	public function save(array $input)
	{
		$inputDot = array_dot($input);

		if( ! $this->valid($inputDot) ) {
			return false;
		}

		return $this->translation->create($input);
	}

	/**
	 * Update an existing translation
	 *
	 * @return boolean
	 */
	public function update(array $input)
	{

		$inputDot = array_dot($input);
		if( ! $this->valid($inputDot) ) {
			return false;
		}

		return $this->translation->update($input);
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
	protected function valid(array $input)
	{
		return $this->validator->with($input)->passes();
	}

}