<?php
namespace TypiCMS\Modules\Pages\Controllers;

use Str;
use View;
use Route;

use TypiCMS\Controllers\PublicController;

use TypiCMS\Modules\Pages\Repositories\PageInterface;

class PagesController extends PublicController
{

    public function __construct(PageInterface $page)
    {
        parent::__construct($page);
        $this->title['parent'] = Str::title(trans_choice('pages::global.pages', 2));
    }

    /**
     * Show page from current uri.
     *
     * @return void
     */
    public function uri()
    {
        $pathArray = explode('.', Route::current()->getName());
        if (count($pathArray) == 1) { // there is only language, so we are on homepage
            $model = $this->repository->getFirstBy('is_home', 1, array('files', 'files.translations'));
        } else {
            $id = array_pop($pathArray);
            $model = $this->repository->byId($id, array('files', 'files.translations'));
        }

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
