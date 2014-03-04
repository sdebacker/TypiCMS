<?php namespace TypiCMS\Modules\Tags\Controllers\Admin;

use View;
use Input;
use Request;
use Paginator;

use TypiCMS\Modules\Tags\Repositories\TagInterface;
use TypiCMS\Modules\Tags\Services\Form\TagForm;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Tags\Presenters\TagPresenter;

// Base controller
use App\Controllers\Admin\BaseController;

class TagsController extends BaseController {

	public function __construct(TagInterface $tag, TagForm $tagform, Presenter $presenter)
	{
		parent::__construct($tag, $tagform, $presenter);
		$this->title['parent'] = trans_choice('tags::global.tags', 2);
	}

	/**
	 * List models
	 * GET /admin/tags
	 */
	public function index()
	{
		if (Request::ajax()) {
			return $this->repository->getAll(true);
		}
		$page = Input::get('page');

		$itemsPerPage = 25;
		$data = $this->repository->byPage($page, $itemsPerPage, true);
		$models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);
		$models = $this->presenter->paginator($models, new TagPresenter);

		$this->layout->content = View::make('tags.admin.index')
			->withModels($models);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($model)
	{
		if ( $this->repository->delete($model) ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}