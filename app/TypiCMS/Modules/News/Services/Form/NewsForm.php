<?php namespace TypiCMS\Modules\News\Services\Form;

use Input;
use Config;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\News\Repositories\NewsInterface;

class NewsForm
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
     * News repository
     *
     * @var \TypiCMS\Modules\News\Repositories\NewsInterface
     */
    protected $news;

    public function __construct(ValidableInterface $validator, NewsInterface $news)
    {
        $this->validator = $validator;
        $this->news = $news;
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

        return $this->news->create($input);
    }

    /**
     * Update an existing news
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

        return $this->news->update($input);
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

        foreach ( $tags as $key => $tag )
        {
            $tags[$key] = trim($tag);
        }

        return $tags;
    }

}