<?php
namespace TypiCMS\Modules\Pages\Controllers;

use App;
use Str;
use View;
use Config;
use Redirect;
use Notification;
use TypiCMS;
use TypiCMS\Modules\Pages\Repositories\PageInterface;
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(PageInterface $page)
    {
        parent::__construct($page);
        $this->title['parent'] = Str::title(trans_choice('pages::global.pages', 2));
    }

    /**
     * Page uri : lang/slug
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|null
     */
    public function uri($uri = null)
    {
        if ($uri == '/') {
            if (Config::get('app.locale_in_url')) {
                return $this->root();
            }
            $model = $this->repository->getFirstBy('is_home', 1);
        } elseif (
            in_array($uri, Config::get('app.locales')) &&
            Config::get('app.locale_in_url')
        ) {
            // Homepage: uri = /en (or other language)
            $model = $this->repository->getFirstBy('is_home', 1);
        } else {
            $model = $this->repository->getFirstByUri($uri);
        }

        if (! $model) {
            App::abort('404');
        }

        $this->title['parent'] = $model->title;

        TypiCMS::setModel($model);

        // get children pages
        $children = $this->repository->getChildren($model->uri);

        $defaultTemplate = 'default';

        $template = $model->template ? $model->template : $defaultTemplate ;
        try {
            $view = View::make('pages.public.' . $template);
        } catch (\InvalidArgumentException $e) {
            Notification::error('<b>Error:</b> Template “' . $template . '” not found.');
            $view = View::make('pages.public.' . $defaultTemplate);
        }

        $this->layout->content = $view
            ->withChildren($children)
            ->withModel($model);
    }

    /**
     * Display the lang chooser
     * or redirect to browser lang
     * or redirect to default lang
     *
     * @return void
     */
    public function root()
    {
        $locales = TypiCMS::getPublicLocales();

        // If we don’t want the lang chooser, redirect to browser language
        if (! Config::get('typicms.langChooser')) {
            $locale = substr(getenv('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            ! in_array($locale, $locales) && $locale = Config::get('app.locale');
            return Redirect::to($locale);
        }

        $this->title['parent'] = 'Choose your language';

        $this->layout->content = View::make('public.root')
            ->with('locales', $locales);
    }
}
