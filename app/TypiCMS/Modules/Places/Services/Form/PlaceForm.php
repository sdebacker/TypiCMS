<?php
namespace TypiCMS\Modules\Places\Services\Form;

use Input;
use Config;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;

class PlaceForm
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
     * Place repository
     *
     * @var \TypiCMS\Modules\Places\Repositories\PlaceInterface
     */
    protected $place;

    public function __construct(ValidableInterface $validator, PlaceInterface $place)
    {
        $this->validator = $validator;
        $this->place = $place;
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

        return $this->place->create($input);
    }

    /**
     * Update an existing place
     *
     * @return boolean
     */
    public function update(array $input)
    {
        // add checkboxes data
        foreach (Config::get('app.locales') as $locale) {
            $input[$locale]['status'] = Input::get($locale.'.status', '0');
        }

        $inputDot = array_dot($input);

        if ( ! $this->valid($inputDot) ) {
            return false;
        }

        return $this->place->update($input);
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
