<?php namespace TypiCMS\Services\Form\Menulink;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Repositories\Menulink\MenulinkInterface;

class MenulinkForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \TypiCMS\Form\Service\ValidableInterface
	 */
	protected $validator;

	/**
	 * Menulink repository
	 *
	 * @var \TypiCMS\Repo\Menulink\MenulinkInterface
	 */
	protected $menulink;

	public function __construct(ValidableInterface $validator, MenulinkInterface $menulink)
	{
		$this->validator = $validator;
		$this->menulink = $menulink;
	}

	/**
	 * Create a new menulink
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

		// $input['tags'] = $this->processTags($input['tags']);

		return $this->menulink->create($input);
	}

	/**
	 * Update an existing menulink
	 *
	 * @return boolean
	 */
	public function update(array $input)
	{
		$inputDot = array_dot($input);

		if( ! $this->valid($inputDot) )
		{
			return false;
		}

		// $input['tags'] = $this->processTags($input['tags']);

		return $this->menulink->update($input);
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