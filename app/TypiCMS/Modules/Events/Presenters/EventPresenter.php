<?php
namespace TypiCMS\Modules\Events\Presenters;

use Route;

use Carbon\Carbon;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class EventPresenter extends AbstractPresenter implements Presentable
{

    public function startDate()
    {
        return $this->object->start_date->format('d.m.Y');
    }

    public function endDdate()
    {
        return $this->object->end_date->format('d.m.Y');
    }

    public function dateFromTo()
    {
        $sDate = $this->object->start_date;
        $eDate = $this->object->end_date;
        $dateFormat = '%d %B %Y';
        $sDateFormat = $dateFormat;
        if ($sDate == $eDate) {
            return ucfirst(trans('events::global.on')) . ' <time datetime="' . $sDate . '">' . $sDate->formatLocalized($dateFormat) . '</time>';
        }
        if ($sDate->format('Y') == $eDate->format('Y')) {
            $sDateFormat = '%d %B';
            if ($sDate->format('m') == $eDate->format('m')) {
                $sDateFormat = '%d';
            }
        }

        return ucfirst(trans('events::global.from')) . ' <time datetime="' . $sDate . '">' . $sDate->formatLocalized($sDateFormat) . '</time> ' . trans('events::global.to') . ' <time datetime="' . $eDate . '">' . $eDate->formatLocalized($dateFormat) . '</time>';
    }
}
