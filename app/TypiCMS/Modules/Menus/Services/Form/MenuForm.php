<?php
namespace TypiCMS\Modules\Menus\Services\Form;

use Input;
use Config;

use TypiCMS\Services\Form\AbstractForm;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Menus\Repositories\MenuInterface;

class MenuForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, MenuInterface $menu)
    {
        $this->validator = $validator;
        $this->repository = $menu;
    }

    public function update(array $input)
    {
        $this->validator->setRule('name', 'required|unique:menus,name,' . $input['id']);

        // add checkboxes data
        foreach (Config::get('app.locales') as $locale) {
            $input[$locale]['status'] = Input::get($locale . '.status', 0);
        }

        $inputDot = array_dot($input);

        if (! $this->valid($inputDot)) {
            return false;
        }

        return $this->repository->update($input);
    }
}
