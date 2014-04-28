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
        $url = route('admin.menus.menulinks.edit', array($this->object->menu_id, $this->object->id));
        return '<a class="btn btn-default btn-xs" href="' . $url . '">' . trans('global.Edit') . '</a>';
    }
}
