<?php
namespace TypiCMS\Modules\Pages\Controllers;

use App;
use Str;
use View;
use Config;

use TypiCMS;

use TypiCMS\Modules\Pages\Repositories\PageInterface;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Pages\Presenters\PagePresenter;

// Base controller
use TypiCMS\Controllers\PublicController;

class PagesController extends PublicController
{

    public function __construct(PageInterface $page, Presenter $presenter)
    {
        parent::__construct($page, $presenter);
        $this->title['parent'] = Str::title(trans_choice('pages::global.pages', 2));
    }

    /**
     * Page uri : lang
     *
     * @return void
     */
    public function homepage($lang = null)
    {
        ! in_array($lang, Config::get('app.locales')) and App::abort(404);
        $model = $this->repository->getFirstBy('is_home', 1, array('files', 'files.translations'));
        $this->prepareForView($model);
    }

    /**
     * Page uri : lang/slug
     *
     * @return void
     */
    public function slug($lang = null, $slug = null)
    {
        $uri = $lang . '/' . $slug;
        $model = $this->repository->byUri($uri);
        $this->prepareForView($model);
    }

    /**
     * Page uri : lang/slug/slug
     *
     * @return void
     */
    public function niv1($lang = null, $niv1 = null, $slug = null)
    {
        $uri = $lang . '/' . $niv1 . '/' . $slug;
        $model = $this->repository->byUri($uri);
        $this->prepareForView($model);
    }

    /**
     * Page uri : lang/slug/slug/slug
     *
     * @return void
     */
    public function niv2($lang = null, $niv1 = null, $niv2 = null, $slug = null)
    {
        $uri = $lang . '/' . $niv1 . '/' . $niv2 . '/' . $slug;
        $model = $this->repository->byUri($uri);
        $this->prepareForView($model);
    }

    /**
     * Show page from model.
     *
     * @param Model $model
     * @return void
     */
    private function prepareForView($model = null)
    {
        $this->title['parent'] = $model->title;

        $model = $this->presenter->model($model, new PagePresenter);

        TypiCMS::setModel($model);

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
