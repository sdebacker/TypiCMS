<?php namespace TypiCMS\Services\Form\Page;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Repositories\Page\PageInterface;

class PageForm {

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
	 * Page repository
	 *
	 * @var \TypiCMS\Repo\Page\PageInterface
	 */
	protected $page;

	public function __construct(ValidableInterface $validator, PageInterface $page)
	{
		$this->validator = $validator;
		$this->page = $page;
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

		// $input['tags'] = $this->processTags($input['tags']);

		return $this->page->create($input);
	}

	/**
	 * Update an existing page
	 *
	 * @return boolean
	 */
	public function update(array $input)
	{
		$inputDot = array_dot($input);

		if( ! $this->valid($inputDot) ) {
			return false;
		}

		// $input['tags'] = $this->processTags($input['tags']);

		return $this->page->update($input);
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

		foreach( $tags as $key => $tag ) {
			$tags[$key] = trim($tag);
		}

		return $tags;
	}

}