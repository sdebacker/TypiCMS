<?php namespace TypiCMS\Modules\Pages\Services\Form;

use Input;
use Config;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Pages\Repositories\PageInterface;

class PageForm
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
     * Page repository
     *
     * @var \TypiCMS\Modules\Pages\Repositories\PageInterface
     */
    protected $page;

    public function __construct(ValidableInterface $validator, PageInterface $page)
    {
        $this->validator = $validator;
        $this->page = $page;
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

        return $this->page->create($input);
    }

    /**
     * Update an existing page
     *
     * @return boolean
     */
    public function update(array $input)
    {
        // add checkboxes data
        $data['rss_enabled']      = Input::get('rss_enabled');
        $data['comments_enabled'] = Input::get('comments_enabled');
        $data['is_home']          = Input::get('is_home');
        foreach (Config::get('app.locales') as $locale) {
            $input[$locale]['status'] = Input::get($locale.'.status');
        }

        $inputDot = array_dot($input);

        if ( ! $this->valid($inputDot) ) {
            return false;
        }

        return $this->page->update($input);
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

        foreach ( $tags as $key => $tag ) {
            $tags[$key] = trim($tag);
        }

        return $tags;
    }

}