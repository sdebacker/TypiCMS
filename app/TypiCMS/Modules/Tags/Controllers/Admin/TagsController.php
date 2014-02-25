<?php namespace TypiCMS\Modules\Tags\Controllers\Admin;

use View;
use Input;
use Request;

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
		$models = $this->repository->byPage($page, 25, true);
		$this->layout->content = View::make('tags.admin.index')
			->withModels($models);
	}

}