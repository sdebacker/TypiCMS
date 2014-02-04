<?php namespace TypiCMS\Services\Form\Menu;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class MenuFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'name' => 'required|regex:/^[a-zA-Z0-9]+$/',
	);

}