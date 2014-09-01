<?php
namespace TypiCMS\Services\Form;

use Input;
use Config;

abstract class AbstractForm
{

    /**
     * Validator
     *
     * @var \TypiCMS\Services\Validation\ValidableInterface
     */
    protected $validator;

    /**
     * Repository
     *
     * @var \TypiCMS\Repositories\RepositoryInterface
     */
    protected $repository;

    /**
     * Create a new item
     *
     * @return boolean
     */
    public function save(array $input)
    {
        $inputDot = array_dot($input);

        if (! $this->valid($inputDot)) {
            return false;
        }

        if (isset($input['tags'])) {
            $input['tags'] = $this->processTags($input['tags']);
        }

        return $this->repository->create($input);
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

        $inputDot = array_dot($input);

        if (! $this->valid($inputDot)) {
            return false;
        }

        if (isset($input['tags'])) {
            $input['tags'] = $this->processTags($input['tags']);
        }

        return $this->repository->update($input);
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
    public function valid(array $input)
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
        if (! $tags) {
            return array();
        }

        $tags = explode(',', $tags);

        foreach ($tags as $key => $tag) {
            $tags[$key] = trim($tag);
        }

        return $tags;
    }
}
