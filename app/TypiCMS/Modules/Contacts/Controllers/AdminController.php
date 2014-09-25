<?php
namespace TypiCMS\Modules\Contacts\Controllers;

use Config;
use Input;
use Paginator;
use TypiCMS\Controllers\BaseAdminController;
use TypiCMS\Modules\Contacts\Repositories\ContactInterface;
use TypiCMS\Modules\Contacts\Services\Form\ContactForm;
use View;

class AdminController extends BaseAdminController
{

    public function __construct(ContactInterface $contact, ContactForm $contactform)
    {
        parent::__construct($contact, $contactform);
        $this->title['parent'] = trans_choice('contacts::global.contacts', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $page = Input::get('page');

        $itemsPerPage = Config::get($this->module . '::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, [], true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('admin.index')->withModels($models);
    }
}
