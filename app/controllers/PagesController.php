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

		$this->title['parent'] = $model->title;

		$template = ($model->template) ? $model->template : 'page' ;

		$this->layout->content = View::make('public.pages.'.$template)
			->with('model', $model);

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
		$pathArray = explode('.',Route::currentRouteName());
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

		$template = ($model->template) ? $model->template : 'page' ;

		$this->layout->content = View::make('public.pages.'.$template)
			->with('model', $model);
	}

}