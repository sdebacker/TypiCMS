<?php
namespace TypiCMS\Modules\Contacts\Controllers;

use App;
use Str;
use View;
use Input;
use Session;
use Redirect;
use TypiCMS;
use TypiCMS\Modules\Contacts\Repositories\ContactInterface;
use TypiCMS\Modules\Contacts\Services\Form\ContactForm;
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    protected $form;

    public function __construct(ContactInterface $contact, ContactForm $contactform)
    {
        $this->form = $contactform;
        parent::__construct($contact);
        $this->title['parent'] = Str::title(trans_choice('contacts::global.contacts', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $model = $this->repository->getmodel();
        $this->layout->content = View::make('contacts.public.form')
            ->with('formIsSent', Session::get('formIsSent'))
            ->withModel($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        App::setLocale(Input::get('locale'));

        if ($this->form->save(Input::all())) {
            Session::flash('formIsSent', true);
            return Redirect::back();
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->form->errors());

    }
}
