<?php namespace TypiCMS\Modules\News\Presenters;

use Carbon\Carbon;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class NewsPresenter extends AbstractPresenter implements Presentable {

	public function date_localized()
	{
		return Carbon::parse($this->object->date)->formatLocalized('%d %B %Y %H:%M');
	}

	public function date_sql()
	{
		return Carbon::parse($this->object->date)->format('Y-m-d H:i:s');
	}

}
