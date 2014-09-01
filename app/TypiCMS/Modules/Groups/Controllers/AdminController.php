<?php
namespace TypiCMS\Modules\Groups\Controllers;

use View;
use Input;
use Request;
use Redirect;
use TypiCMS\Modules\Groups\Repositories\GroupInterface;
use TypiCMS\Modules\Groups\Services\Form\GroupForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    /**
     * __construct
     *
     * @param GroupInterface $group
     * @param GroupForm     $groupForm
     */
    public function __construct(GroupInterface $group, GroupForm $groupForm)
    {
        parent::__construct($group, $groupForm);
        $this->title['parent'] = trans_choice('groups::global.groups', 2);

        // Establish Filters
        $this->beforeFilter('inGroup:Admins');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $models = $this->repository->all();

        $this->layout->content = View::make('admin.groups.index')->withModels($models);
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($id)
    {
        //Show a group and its permissions.
        $group = $this->repository->byId($id);

        $this->layout->content = View::make('admin.groups.show')->with('group', $group);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('groups::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('admin.groups.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->title['child'] = trans('groups::global.Edit');

        $group = $this->repository->byId($id);
        $this->layout->content = View::make('admin.groups.edit')
            ->withPermissions($group->getPermissions())
            ->withModel($group);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ($model = $this->form->save(Input::all())) {
            return (Input::get('exit')) ?
                Redirect::route('admin.groups.index') :
                Redirect::route('admin.groups.edit', $model->id) ;
        }

        return Redirect::route('admin.groups.create')
            ->withInput()
            ->withErrors($this->form->errors());
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($id)
    {

        if ($this->form->update(Input::all())) {
            return (Input::get('exit')) ?
                Redirect::route('admin.groups.index') :
                Redirect::route('admin.groups.edit', $id) ;
        }

        return Redirect::route('admin.groups.edit', $id)
            ->withInput()
            ->withErrors($this->form->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->repository->destroy($id)) {
            if (! Request::ajax()) {
                return Redirect::back();
            }
        }
    }
}
