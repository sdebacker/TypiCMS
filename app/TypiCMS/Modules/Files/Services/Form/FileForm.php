<?php namespace TypiCMS\Modules\Files\Services\Form;

use Input;
use Config;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Files\Repositories\FileInterface;

class FileForm {

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
	 * File repository
	 *
	 * @var \TypiCMS\Modules\Files\Repositories\FileInterface
	 */
	protected $file;

	public function __construct(ValidableInterface $validator, FileInterface $file)
	{
		$this->validator = $validator;
		$this->file = $file;
	}

	/**
	 * Create an new file
	 *
	 * @return boolean
	 */
	public function save(array $input)
	{
		$inputDot = array_dot($input);

		if( ! $this->valid($inputDot) )
		{
			return false;
		}

		return $this->file->create($input);
	}

	/**
	 * Update an existing file
	 *
	 * @return boolean
	 */
	public function update(array $input)
	{
		// add checkboxes data
		foreach (Config::get('app.locales') as $locale) {
			$input[$locale]['status'] = Input::get($locale.'.status');
		}

		$inputDot = array_dot($input);

		if( ! $this->valid($inputDot) )
		{
			return false;
		}

		return $this->file->update($input);
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

	/**
	 * Convert string of tags to
	 * array of tags
	 *
	 * @param  string
	 * @return array
	 */
	protected function processTags($tags)
	{
		$tags = explode(',', $tags);

		foreach( $tags as $key => $tag )
		{
			$tags[$key] = trim($tag);
		}

		return $tags;
	}

}