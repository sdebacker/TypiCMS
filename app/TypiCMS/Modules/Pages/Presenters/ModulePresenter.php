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
        return '/' . $this->entity->$lang->uri;
    }

    /**
     * Get Uri truncated
     * 
     * @return string URI without last segment
     */
    public function parentUri($lang)
    {
        $parentUri = $this->entity->$lang->uri ;
        if (! $parentUri) {
            return $lang . '/' ;
        }
        $parentUri = explode('/', $parentUri);
        array_pop($parentUri);
        $parentUri = implode('/', $parentUri) . '/';

        return $parentUri;
    }
}
