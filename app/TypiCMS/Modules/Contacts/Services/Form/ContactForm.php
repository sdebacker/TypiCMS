<?php
namespace TypiCMS\Modules\Contacts\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Contacts\Repositories\ContactInterface;

class ContactForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, ContactInterface $contact)
    {
        $this->validator = $validator;
        $this->repository = $contact;
    }

    /**
     * Sanitize and save contact form
     *
     * @return boolean
     */
    public function save(array $crap)
    {
        $input = array();
        foreach ($crap as $key => $value) {
            $input[$key] = e($value);
        }

        if (! $this->valid($input)) {
            return false;
        }

        return $this->repository->create($input);
    }
}
