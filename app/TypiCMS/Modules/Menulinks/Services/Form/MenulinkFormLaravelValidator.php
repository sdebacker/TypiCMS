<?php namespace TypiCMS\Modules\Menulinks\Services\Form;

use TypiCMS\Services\Validation\AbstractLaravelValidator;

class MenulinkFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
	protected $rules = array(
		'fr.title' => 'required',
		'menu_id' => 'required',
	);

}