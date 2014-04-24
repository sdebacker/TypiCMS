<?php
namespace TypiCMS\Modules\Contacts\Services\Form;

use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Contacts\Repositories\ContactInterface;

class ContactForm
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
     * Contact repository
     *
     * @var \TypiCMS\Modules\Contacts\Repositories\ContactInterface
     */
    protected $contact;

    public function __construct(ValidableInterface $validator, ContactInterface $contact)
    {
        $this->validator = $validator;
        $this->contact = $contact;
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

        return $this->contact->create($input);
    }

    /**
     * Update an existing contact
     *
     * @return boolean
     */
    public function update(array $input)
    {
        $inputDot = array_dot($input);

        if ( ! $this->valid($inputDot) ) {
            return false;
        }

        return $this->contact->update($input);
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

}
