<?php
namespace TypiCMS\Modules\Pages\Services\Form;

use Input;
use Config;
use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Pages\Repositories\PageInterface;

class PageForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, PageInterface $page)
    {
        $this->validator = $validator;
        $this->repository = $page;
    }

    /**
     * Update an existing item
     *
     * @return boolean
     */
    public function update(array $input)
    {
        // add checkboxes data
        foreach (Config::get('app.locales') as $locale) {
            $input[$locale]['status'] = Input::get($locale.'.status', 0);
        }
        $input['rss_enabled']      = Input::get('rss_enabled', 0);
        $input['comments_enabled'] = Input::get('comments_enabled', 0);
        $input['is_home']          = Input::get('is_home', 0);

        $inputDot = array_dot($input);

        if (! $this->valid($inputDot)) {
            return false;
        }

        return $this->repository->update($input);
    }
}
