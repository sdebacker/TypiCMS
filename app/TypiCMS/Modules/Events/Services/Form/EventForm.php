<?php namespace TypiCMS\Modules\Events\Services\Form;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Events\Repositories\EventInterface;

class EventForm {

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
	 * Event repository
	 *
	 * @var \TypiCMS\Modules\Events\Repositories\EventInterface
	 */
	protected $event;

	public function __construct(ValidableInterface $validator, EventInterface $event)
	{
		$this->validator = $validator;
		$this->event = $event;
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

		return $this->event->create($input);
	}

	/**
	 * Update an existing event
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

		if( ! $this->valid($inputDot) ) {
			return false;
		}

		return $this->event->update($input);
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