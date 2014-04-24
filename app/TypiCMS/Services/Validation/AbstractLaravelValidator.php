<?php
namespace TypiCMS\Services\Validation;

use Illuminate\Validation\Factory;

abstract class AbstractLaravelValidator implements ValidableInterface
{

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Validation data key => value array
     *
     * @var Array
     */
    protected $data = array();

    /**
     * Validation errors
     *
     * @var Array
     */
    protected $errors = array();

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array();

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Set data to validate
     *
     * @return \TypiCMS\Services\Validation\AbstractLaravelValidator
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Validation passes or fails
     *
     * @return Boolean
     */
    public function passes()
    {
        $validator = $this->validator->make($this->data, $this->rules);

        if ($validator->fails()) {
            $this->errors = $validator->messages();

            return false;
        }

        return true;
    }

    /**
     * Return errors, if any
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * getRules
     *
     * @return $this->rules array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * setRule
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setRule($key, $value)
    {
        $this->rules[$key] = $value;

        return $this;
    }

    /**
     * emptyRules
     *
     * @return $this
     */
    public function emptyRules()
    {
        $this->rules = array();

        return $this;
    }
}
