<?php
namespace TypiCMS\Modules\Pages\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Get public url
     * @param  string $lang
     * @return string       uri
     */
    public function publicUri($lang)
    {
        if ($this->entity->is_home) {
            return '/' . $lang;
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
        $parentUri = $this->entity->translate($lang)->uri ;
        if (! $parentUri) {
            return $lang . '/' ;
        }
        $parentUri = explode('/', $parentUri);
        array_pop($parentUri);
        $parentUri = implode('/', $parentUri) . '/';

        return $parentUri;
    }
}
