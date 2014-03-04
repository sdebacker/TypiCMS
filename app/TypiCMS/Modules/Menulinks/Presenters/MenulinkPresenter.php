<?php namespace TypiCMS\Modules\Menulinks\Presenters;
 
use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class MenulinkPresenter extends AbstractPresenter implements Presentable {

	public function menuclass()
	{
		return $this->object->menuclass;
	}
}
