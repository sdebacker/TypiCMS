<?php
namespace TypiCMS\Modules\Pages\Presenters;

use TypiCMS\Presenters\Presenter;

class PagePresenter extends Presenter
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
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when object has menulinks
        $disabled = $this->entity->is_home ? ' disabled' : '' ;

        return '<input type="checkbox" value="' . $this->entity->id . '"' . $disabled . '>';
    }
}
