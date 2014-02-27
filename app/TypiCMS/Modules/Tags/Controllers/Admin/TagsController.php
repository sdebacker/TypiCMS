<?php namespace TypiCMS\Modules\Tags\Controllers\Admin;

use View;
use Input;
use Request;
use Paginator;

use App\Controllers\Admin\BaseController;

use TypiCMS\Modules\Tags\Repositories\TagInterface;

class TagsController extends BaseController {

	public function __construct(TagInterface $tag)
	{
		parent::__construct($tag);
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