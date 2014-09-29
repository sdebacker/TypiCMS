<?php
namespace TypiCMS\Modules\Contacts\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Contacts\Repositories\ContactInterface;
use TypiCMS\Modules\Contacts\Services\Form\ContactForm;

class AdminController extends AdminSimpleController
{

    public function __construct(ContactInterface $contact, ContactForm $contactform)
    {
        parent::__construct($contact, $contactform);
        $this->title['parent'] = trans_choice('contacts::global.contacts', 2);
    }
}
