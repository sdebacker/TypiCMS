<?php namespace TypiCMS\Modules\Files\Controllers\Admin;

use TypiCMS\Modules\Files\Repositories\FileInterface;
use TypiCMS\Modules\Files\Services\Form\FileForm;

use App\Controllers\Admin\BaseController;

use View;
use Input;
use Redirect;
use Request;
use Notification;

class FilesController extends BaseController {

	public function __construct(FileInterface $file, FileForm $fileform)
	{
		parent::__construct($file, $fileform);
		$this->title['parent'] = trans_choice('modules.files.files', 2);
	}


	/**
	 * Upoad files
	 * POST /admin/files/upload
	 */
	public function upload()
	{

		$this->repository->upload(Input::all());

		if ( ! Request::ajax()) {
			return Redirect::back();
		}

	}


	/**
	 * List models
	 * GET /admin/model
	 */
	public function index($parent = null)
	{
		$models = $this->repository->getAll(true, $parent);
		if ($parent) {
			$this->layout->content = View::make('files.admin.index')
				->withModels($models)
				->withParent($parent);
		} else {
			$this->layout->content = View::make('files.admin.all')
				->withModels($models);
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($parent)
	{
		$model = $this->repository->getModel();
		$this->title['child'] = trans('modules.files.New');
		$this->layout->content = View::make('files.admin.create')
			->withModel($model)
			->withParent($parent);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($parent, $model)
	{
		$this->title['child'] = trans('modules.files.Edit');
		$this->layout->content = View::make('files.admin.edit')
			->withModel($model)
			->withParent($parent);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($parent, $model)
	{
		return Redirect::route('admin.' . $parent->route . '.files.edit', array($parent->id, $model->id));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($parent)
	{
		// Numeric values must be integer for checkboxes not to be checked.
		$post = array();
		foreach (Input::all() as $key => $value) {
			$post[$key] = is_numeric($value) ? (int) $value : $value ;
		}

		if ( $this->form->save( Input::all() ) ) {
			return Redirect::route('admin.' . $parent->route . '.files.index', $parent->id);
		}

		return Redirect::route('admin.' . $parent->route . '.files.create', $parent->id)
			->withInput()
			->withErrors($this->form->errors());

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($parent, $model)
	{

		Request::ajax() and exit($this->repository->update( Input::all() ));

		if ( $this->form->update( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.' . $parent->route . '.files.index', $parent->id) : Redirect::route('admin.' . $parent->route . '.files.edit', array($parent->id, $model->id)) ;
		}
		
		return Redirect::route( 'admin.' . $parent->route . '.files.edit', array($parent->id, $model->id) )
			->withInput()
			->withErrors($this->form->errors());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function sort()
	{
		$sort = $this->repository->sort( Input::all() );
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($parent, $model)
	{
		if( $this->repository->delete($model) ) {
			if ( ! Request::ajax()) {
				Notification::success('File '.$model->filename.' deleted.');
				return Redirect::back();
			}
		} else {
			Notification::error('Error deleting file '.$model->filename.'.');
		}
	}


}