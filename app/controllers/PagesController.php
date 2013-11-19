<?php namespace App\Controllers;

use Route;
use View;
use Request;
use Log;

use TypiCMS\Repositories\Page\PageInterface;

class PagesController extends BaseController {

	public function __construct(PageInterface $page)
	{
		parent::__construct($page);
		$this->title['parent'] = trans_choice('global.modules.pages', 2);
	}

	/**
	 * Fonction appelée depuis routes.php.
	 * Prends en DB la page ayant l’attribut is_home = 1
	 * et lance la methode show($id)
	 *
	 * @return void
	 */
	public function homepage()
	{
		$model = $this->repository->getHomePage();

		return $this->show($model->id);

	}

	/**
	 * Fonction appelée depuis routes.php.
	 * Extrait l’id de la page depuis le nom de la route
	 * et lance la methode show($id)
	 *
	 * @return void
	 */
	public function uri()
	{
		$pathArray = explode('.', Route::currentRouteName());
		// Laravel 4.1 : 
		// $pathArray = explode('.', Route::current()->getName());
		
		$pageId = array_pop($pathArray);
		$this->show($pageId);
	}

	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$model = $this->repository->byId($id);

		$this->title['parent'] = $model->title;

		// get children pages
		$childrenModels = $this->repository->getChildren($model->uri);

		// build side menu
		$sideMenu = $this->repository->buildSideList($childrenModels);

		$template = ($model->template) ? $model->template : 'page' ;

		$this->layout->content = View::make('public.pages.'.$template)
			->with('sideMenu', $sideMenu)
			->withModel($model)
			->nest('files', 'public.files._list', array('models' => $model->files));
	}

}