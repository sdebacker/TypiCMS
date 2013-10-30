<?php namespace TypiCMS\Services\Form\File;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class FileFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'file' => 'mimes:jpeg,gif,png'
	);

}