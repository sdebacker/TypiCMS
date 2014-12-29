<?php
namespace TypiCMS\Modules\Pages\Controllers;

use App;
use Config;
use InvalidArgumentException;
use Notification;
use Redirect;
use Str;
use TypiCMS;
use TypiCMS\Controllers\BasePublicController;
use TypiCMS\Modules\Pages\Repositories\PageInterface;
use View;

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
     * @return void
     */
    public function uri($uri = null)
    {
        if ($uri == '/') {
            if (Config::get('typicms.langChooser')) {
                return $this->langChooser();
            }
            if (Config::get('app.main_locale_in_url')) {
                return $this->redirectToBrowserLanguage();
            }
            $model = $this->repository->getFirstBy('is_home', 1);
        } else if (
            in_array($uri, Config::get('app.locales')) &&
            (Config::get('app.fallback_locale') != App::getLocale() ||
            Config::get('app.main_locale_in_url'))
        ) {
            $model = $this->repository->getFirstBy('is_home', 1);
        } else {
            $model = $this->repository->getFirstByUri($uri);
        }

        if (! $model) {
            App::abort('404');
        }

        $this->title['parent'] = $model->title;

        TypiCMS::setModel($model);

        // get submenu
        $children = $this->repository->getSubMenu($model->uri);

        $defaultTemplate = 'default';

        $template = $model->template ? $model->template : $defaultTemplate ;
        try {
            $view = View::make('pages.public.' . $template);
        } catch (InvalidArgumentException $e) {
            Notification::error('<b>Error:</b> Template “' . $template . '” not found.');
            $view = View::make('pages.public.' . $defaultTemplate);
        }

        $this->layout->content = $view
            ->withChildren($children)
            ->withModel($model);
    }

    /**
     * Redirect to browser language or default locale
     *
     * @return Redirect
     */
    public function redirectToBrowserLanguage()
    {
        $locales = TypiCMS::getPublicLocales();
        $locale = substr(getenv('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        ! in_array($locale, $locales) && $locale = Config::get('app.locale');
        return Redirect::to($locale);
    }

    /**
     * Display the lang chooser
     *
     * @return void
     */
    public function langChooser()
    {
        $locales = TypiCMS::getPublicLocales();

        $this->title['parent'] = 'Choose your language';

        $this->layout->content = View::make('public.langChooser')
            ->with('locales', $locales);
    }
}
