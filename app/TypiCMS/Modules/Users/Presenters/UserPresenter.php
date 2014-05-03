<?php
namespace TypiCMS\Modules\Users\Presenters;

use TypiCMS\Presenters\Presenter;

class UserPresenter extends Presenter
{

    public function activated()
    {
        return $this->entity->isActivated() ? trans('global.Yes') : trans('global.No') ;
    }

    public function superUser()
    {
        return $this->entity->isSuperUser() ? trans('global.Yes') : trans('global.No') ;
    }

    public function status()
    {
        return $this->entity->status;
    }
}
