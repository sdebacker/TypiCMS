<?php
namespace TypiCMS\Modules\Menulinks\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class MenulinkPresenter extends AbstractPresenter implements Presentable
{

    public function menuclass()
    {
        return $this->object->menuclass;
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function edit()
    {
        return '<a class="btn btn-default btn-xs" href="' . route('admin.menus.menulinks.edit', array($this->object->menu_id, $this->object->id)) . '">' . trans('global.Edit') . '</a>';
    }

}
