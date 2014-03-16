<?php namespace TypiCMS\Modules\Users\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class UserPresenter extends AbstractPresenter implements Presentable
{

    public function activated()
    {
        return $this->object->isActivated() ? trans('global.Yes') : trans('global.No') ;
    }

    public function superUser()
    {
        return $this->object->isSuperUser() ? trans('global.Yes') : trans('global.No') ;
    }

    public function status()
    {
        return $this->object->status;
    }

}
