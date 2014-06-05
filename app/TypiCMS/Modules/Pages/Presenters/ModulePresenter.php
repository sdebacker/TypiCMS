<?php
namespace TypiCMS\Modules\Pages\Presenters;

use Config;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Get public url
     * 
     * @param  string $lang
     * @return string       uri
     */
    public function publicUri($lang)
    {
        if ($this->entity->is_home) {
            if (Config::get('app.locale_in_url')) {
                return '/' . $lang;
            }
            return '/';
        }
        return '/' . $this->entity->translate($lang)->uri;
    }

    /**
     * Get Uri truncated
     * 
     * @return string URI without last segment
     */
    public function parentUri($lang)
    {
        $parentUri = $this->entity->translate($lang)->uri;
        if (! $parentUri) {
            if (Config::get('app.locale_in_url')) {
                return $lang . '/';
            }
            return '/';
        }
        $parentUri = explode('/', $parentUri);
        array_pop($parentUri);
        $parentUri = implode('/', $parentUri) . '/';

        return $parentUri;
    }
}
