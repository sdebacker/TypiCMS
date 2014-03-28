<?php
namespace TypiCMS\Modules\News\Presenters;

use Carbon\Carbon;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class NewsPresenter extends AbstractPresenter implements Presentable
{

    public function dateLocalized()
    {
        return $this->object->date->formatLocalized('%d %B %Y %H:%M');
    }

    public function dateOrDefault()
    {
        return $this->object->date ? : Carbon::now();
    }

}
