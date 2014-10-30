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
     * Create a new item
     *
     * @return boolean
     */
    public function save(array $input)
    {
        $input['parent_id'] = null;
        return parent::save($input);
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
        $input['parent_id']      = Input::get('parent_id') ? : null ;
        return parent::update($input);
    }
}
