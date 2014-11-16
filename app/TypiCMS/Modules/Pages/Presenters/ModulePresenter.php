<?php
namespace TypiCMS\Modules\Pages\Presenters;

use Config;
use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Get Uri without last segment
     *
     * @param  string $lang
     * @return string URI without last segment
     */
    public function parentUri($lang)
    {
        $parentUri = $this->entity->translate($lang)->uri;
        if (! $parentUri) {
            if (
                ! Config::get('typicms.langChooser') &&
                Config::get('app.fallback_locale') == $lang &&
                ! Config::get('app.main_locale_in_url')
            ) {
                return '/';
            }
            return $lang . '/';
        }
        $parentUri = explode('/', $parentUri);
        array_pop($parentUri);
        $parentUri = implode('/', $parentUri) . '/';

        return $parentUri;
    }
}
