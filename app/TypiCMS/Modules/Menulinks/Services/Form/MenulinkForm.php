<?php
namespace TypiCMS\Modules\Menulinks\Services\Form;

use Input;
use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface;

class MenulinkForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, MenulinkInterface $menulink)
    {
        $this->validator = $validator;
        $this->repository = $menulink;
    }

    /**
     * Update an existing item
     *
     * @return boolean
     */
    public function update(array $input)
    {
        // add checkboxes data
        $input['has_categories'] = Input::get('has_categories', 0);
        return parent::update($input);
    }
}
