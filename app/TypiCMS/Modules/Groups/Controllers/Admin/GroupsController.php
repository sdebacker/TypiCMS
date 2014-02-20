<?php namespace TypiCMS\Modules\Groups\Controllers\Admin;

use Lang;
use View;
use Input;
use Sentry;
use Config;
use Redirect;
use Notification;

use TypiCMS\Modules\Groups\Repositories\GroupInterface;
use TypiCMS\Modules\Groups\Services\Form\GroupForm;

use App\Controllers\Admin\BaseController;

class GroupsController extends BaseController {

	/**
	 * __construct
	 *
	 * @param Groupnterface $group
	 * @param GroupForm $groupform
	 */
	public function __construct(GroupInterface $group, GroupForm $groupForm) 
	{
		parent::__construct($group, $groupForm);
		$this->title['parent'] = trans_choice('modules.groups.groups', 2);

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
		$groups = $this->repository->all();
		$this->layout->content = View::make('admin.groups.index')->with('groups', $groups);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->title['child'] = trans('modules.groups.New');

		$this->layout->content = View::make('admin.groups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Form Processing
		$result = $this->form->save( Input::all() );

		if( $result['success'] ) {
			// Success!
			Notification::success($result['message']);
			return Redirect::to('admin/groups');

		} else {
			Notification::error($result['message']);
			return Redirect::action('GroupController@create')
				->withInput()
				->withErrors( $this->form->errors() );
		}
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
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$this->title['child'] = trans('modules.groups.Edit');

		$group = $this->repository->byId($id);
		$this->layout->content = View::make('admin.groups.edit')
			->withPermissions($group->getPermissions())
			->with('group', $group);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		// Form Processing
		$result = $this->form->update( Input::all() );

		if( $result['success'] )
		{
			// Success!
			Notification::success($result['message']);
			return Redirect::to('admin/groups');

		} else {
			Notification::error($result['message']);
			return Redirect::action('GroupController@create')
				->withInput()
				->withErrors( $this->form->errors() );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->repository->destroy($id))
		{
			Notification::success('Group Deleted');
			return Redirect::to('admin/groups');
		}
		else 
		{
			Notification::error('Unable to Delete Group');
			return Redirect::to('admin/groups');
		}
	}

}