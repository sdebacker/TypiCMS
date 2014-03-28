<?php
namespace TypiCMS\Modules\Menus\Services\Form;

use Input;
use Config;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Menus\Repositories\MenuInterface;

class MenuForm
{

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
     * Menu repository
     *
     * @var \TypiCMS\Modules\Menus\Repositories\MenuInterface
     */
    protected $menu;

    public function __construct(ValidableInterface $validator, MenuInterface $menu)
    {
        $this->validator = $validator;
        $this->menu = $menu;
    }

    /**
     * Create a new page
     *
     * @return boolean
     */
    public function save(array $input)
    {
        $inputDot = array_dot($input);

        if ( ! $this->valid($inputDot) ) {
            return false;
        }

        return $this->menu->create($input);
    }

    /**
     * Update an existing menu
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

        if ( ! $this->valid($inputDot) ) {
            return false;
        }

        return $this->menu->update($input);
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

        foreach ($tags as $key => $tag) {
            $tags[$key] = trim($tag);
        }

        return $tags;
    }

}
