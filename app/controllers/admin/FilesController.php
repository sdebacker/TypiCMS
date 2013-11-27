<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\File\FileInterface;
use TypiCMS\Services\Form\File\FileForm;
use View;
use Former;
use Input;
use Redirect;
use Request;
use Notification;

class FilesController extends BaseController {

	public function __construct(FileInterface $file, FileForm $fileform)
	{
		parent::__construct($file, $fileform);
		$this->title['parent'] = trans_choice('global.modules.files', 2);
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
	public function index($relatedModel = null)
	{
		$models = $this->repository->getAll(true, $relatedModel)->buildList($this->repository->getListProperties());
		$this->layout->content = View::make('admin.files.index')->withModels($models)->with('relatedModel', $relatedModel);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = $this->repository;
		$this->title['child'] = trans('files.New');
		$this->layout->content = View::make('admin.files.create')
			->with('model', $model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($model)
	{
		// $relatedModel = with(new $model->fileable_type)->find($model->fileable_id);
		// d($relatedModel);

		$this->title['child'] = trans('files.Edit');
		$model->setTranslatedFields();
		Former::populate($model);
		$this->layout->content = View::make('admin.files.edit')
			->with('model', $model);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($model)
	{
		return Redirect::route('admin.files.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Numeric values must be integer for checkboxes not to be checked.
		$post = array();
		foreach (Input::all() as $key => $value) {
			$post[$key] = is_numeric($value) ? (int) $value : $value ;
		}

		if ( $this->form->save( Input::all() ) ) {
			return Redirect::route('admin.files.index');
		}

		return Redirect::route('admin.files.create')
			->withInput()
			->withErrors($this->form->errors());

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($model)
	{

		if ( ! Request::ajax()) {
			if ( $this->form->update( Input::all() ) ) {
				return Redirect::route('admin.files.index');
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.files.edit', $model->id )
				->withInput()
				->withErrors($this->form->errors());
		}
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
	public function destroy($relatedModel, $model)
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