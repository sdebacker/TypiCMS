<?php namespace TypiCMS\Modules\Projects\Services\Form;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface;

class ProjectForm {

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
	 * Project repository
	 *
	 * @var \TypiCMS\Repo\Project\ProjectInterface
	 */
	protected $project;

	public function __construct(ValidableInterface $validator, ProjectInterface $project)
	{
		$this->validator = $validator;
		$this->project = $project;
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

        $input['tags'] = $this->processTags($input['tags']);

		return $this->project->create($input);
	}

	/**
	 * Update an existing project
	 *
	 * @return boolean
	 */
	public function update(array $input)
	{
		$inputDot = array_dot($input);

		if( ! $this->valid($inputDot) ) {
			return false;
		}

        $input['tags'] = $this->processTags($input['tags']);

		return $this->project->update($input);
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

		$tags = $tags ? explode(',', $tags) : array();

		foreach( $tags as $key => $tag ) {
			$tags[$key] = trim($tag);
		}

		return $tags;
	}

}