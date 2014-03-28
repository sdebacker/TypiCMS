<?php
namespace TypiCMS\Modules\Events\Presenters;

use Route;

use Carbon\Carbon;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class EventPresenter extends AbstractPresenter implements Presentable
{

    public function startDateOrDefault()
    {
        return $this->object->start_date->format('Y-m-d') ? : Carbon::now()->format('Y-m-d');
    }

    public function endDateOrDefault()
    {
        return $this->object->end_date->format('Y-m-d') ? : Carbon::now()->format('Y-m-d');
    }

    public function start_date()
    {
        return $this->object->start_date->format('d.m.Y');
    }

    public function end_date()
    {
        return $this->object->end_date->format('d.m.Y');
    }

    public function date_from_to()
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
