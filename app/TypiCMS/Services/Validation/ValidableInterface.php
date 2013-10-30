<?php namespace TypiCMS\Services\Validation;

interface ValidableInterface {

    /**
     * Add data to validation against
     *
     * @param array
     * @return \TypiCMS\Services\Validation\ValidableInterface  $this
     */
    public function with(array $input);

    /**
     * Test if validation passes
     *
     * @return boolean
     */
    public function passes();

    /**
     * Retrieve validation errors
     *
     * @return array
     */
    public function errors();

}