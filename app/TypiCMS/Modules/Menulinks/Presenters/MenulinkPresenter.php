<?php
namespace TypiCMS\Modules\Menulinks\Presenters;

use TypiCMS\Presenters\Presenter;

class MenulinkPresenter extends Presenter
{

    public function menuclass()
    {
        return $this->entity->menuclass;
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function edit()
    {
        $url = route('admin.menus.menulinks.edit', array($this->entity->menu_id, $this->entity->id));
        return '<a class="btn btn-default btn-xs" href="' . $url . '">' . trans('global.Edit') . '</a>';
    }
}
