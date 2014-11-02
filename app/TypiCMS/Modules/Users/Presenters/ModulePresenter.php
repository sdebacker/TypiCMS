<?php
namespace TypiCMS\Modules\Users\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

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

    /**
     * Concatenate first_name and last_name
     * 
     * @return String
     */
    public function title()
    {
        return $this->entity->first_name . ' ' . $this->entity->last_name;
    }
}
