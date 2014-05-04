<?php
namespace TypiCMS\Modules\Users\Presenters;

use Sentry;

use TypiCMS\Presenters\Presenter;

class UserPresenter extends Presenter
{

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when object has menulinks
        $disabled = (Sentry::getUser() == $this->entity) ? '' : ' disabled' ;

        return '<input type="checkbox" value="' . $this->entity->id . '"' . $disabled . '>';
    }

    /**
     * check if user is activated
     * 
     * @return string translated 'yes' or 'no'
     */
    public function activated()
    {
        return $this->entity->isActivated() ? trans('global.Yes') : trans('global.No') ;
    }

    /**
     * Is user superuser ?
     * 
     * @return string translated 'yes' or 'no'
     */
    public function superUser()
    {
        return $this->entity->isSuperUser() ? trans('global.Yes') : trans('global.No') ;
    }
}
