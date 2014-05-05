<?php
namespace TypiCMS\Modules\Pages\Controllers;

use App;
use Str;
use View;
use Config;
use Redirect;

use TypiCMS;

use TypiCMS\Modules\Pages\Repositories\PageInterface;

// Base controller
use TypiCMS\Controllers\PublicController;

class PagesController extends PublicController
{

    public function __construct(PageInterface $page)
    {
        parent::__construct($page);
        $this->title['parent'] = Str::title(trans_choice('pages::global.pages', 2));
    }

    /**
     * Page uri : lang/slug
     *
     * @return void
     */
    public function uri($uri = null)
    {
        if ($uri == '/') {
            return $this->root();
        }

        if (in_array($uri, Config::get('app.locales'))) {
            // Homepage: uri = /en (or other language)
            $model = $this->repository->getFirstBy('is_home', 1);
        } else {
            $model = $this->repository->byUri($uri);
        }

        if (! $model) {
            App::abort('404');
        }

        $this->title['parent'] = $model->title;

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

    /**
     * Show lang chooser, redirect to browser lang or redirect to default lang
     *
     * @return void
     */
    public function root()
    {
        $locales = Config::get('app.locales');

        // If we don’t want the lang chooser, redirect to browser language
        if (! Config::get('typicms.langChooser')) {
            $locale = substr(getenv('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            ! in_array($locale, $locales) and $locale = Config::get('app.locale');
            return Redirect::to($locale);
        }

        $this->title['parent'] = 'Choose your language';

        $this->layout->content = View::make('public.root')
            ->with('locales', $locales);
    }
}
