<?php namespace TypiCMS\Modules\Pages\Controllers;

use Str;
use View;
use Route;

use App\Controllers\BaseController;

use TypiCMS\Modules\Pages\Repositories\PageInterface;

class PagesController extends BaseController {

    public function __construct(PageInterface $page)
    {
        parent::__construct($page);
        $this->title['parent'] = Str::title(trans_choice('pages::global.pages', 2));
    }

    /**
     * Get homepage (is_home attr)
     *
     * @return void
     */
    public function homepage()
    {
        $model = $this->repository->getHomePage();

        if ($model) {
            return $this->show($model->id);
        }

    }

    /**
     * We have uri, find id and show page
     *
     * @return void
     */
    public function uri()
    {
        $pathArray = explode('.', Route::current()->getName());
        
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

        $this->layout->content = View::make('pages.public.'.$template)
            ->with('sideMenu', $sideMenu)
            ->withModel($model);
    }

}