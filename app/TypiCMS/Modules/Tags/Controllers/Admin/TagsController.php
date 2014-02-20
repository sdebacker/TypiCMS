<?php namespace TypiCMS\Modules\Tags\Controllers\Admin;

use TypiCMS\Modules\Tags\Repositories\TagInterface;

use App\Controllers\Admin\BaseController;

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
		return $this->repository->getAll(true);
	}

}