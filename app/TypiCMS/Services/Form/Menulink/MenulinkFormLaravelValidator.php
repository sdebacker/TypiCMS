<?php namespace TypiCMS\Services\Form\Menulink;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class MenulinkFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'fr.title' => 'required',
	);

}