<?php
namespace TypiCMS\Modules\Translations\Controllers;

use View;
use Input;
use Request;
use Redirect;
use Response;
use Illuminate\Support\Collection;
use TypiCMS\Modules\Translations\Repositories\TranslationInterface;
use TypiCMS\Modules\Translations\Services\Form\TranslationForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(TranslationInterface $translation, TranslationForm $translationform)
    {
        parent::__construct($translation, $translationform);
        $this->title['parent'] = trans_choice('translations::global.translations', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = Collection::make($this->repository->getAll(array(), true));

        $this->layout->content = View::make('translations.admin.index')
            ->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('translations::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('translations.admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('translations::global.Edit');
        $this->layout->content = View::make('translations.admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.translations.edit', $model->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ($model = $this->form->save(Input::all())) {
            return Input::get('exit') ?
                Redirect::route('admin.translations.index') :
                Redirect::route('admin.translations.edit', $model->id) ;
        }

        return Redirect::route('admin.translations.create')
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($model)
    {

        if (Request::ajax()) {
            return Response::json($this->repository->update(Input::all()));
        }

        if ($this->form->update(Input::all())) {
            return Input::get('exit') ?
                Redirect::route('admin.translations.index') :
                Redirect::route('admin.translations.edit', $model->id) ;
        }

        return Redirect::route('admin.translations.edit', $model->id)
            ->withInput()
            ->withErrors($this->form->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($model)
    {
        if ($this->repository->delete($model)) {
            if (! Request::ajax()) {
                return Redirect::back();
            }
        }
    }
}
