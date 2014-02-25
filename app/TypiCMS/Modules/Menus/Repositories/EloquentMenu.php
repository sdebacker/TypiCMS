<?php namespace TypiCMS\Modules\Menus\Repositories;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentMenu extends RepositoriesAbstract implements MenuInterface {

	// Class expects an Eloquent model
	public function __construct(Model $model)
	{
		$this->model = $model;
	}


}