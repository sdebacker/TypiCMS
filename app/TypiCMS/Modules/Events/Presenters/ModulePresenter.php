<?php
namespace TypiCMS\Modules\Events\Presenters;

use Route;

use Carbon\Carbon;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    public function startDate()
    {
        return $this->entity->start_date->format('d.m.Y');
    }

    public function endDate()
    {
        return $this->entity->end_date->format('d.m.Y');
    }

    public function dateFromTo()
    {
        $sDate = $this->entity->start_date;
        $eDate = $this->entity->end_date;
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

        $dateFromTo  = ucfirst(trans('events::global.from')) . ' ';
        $dateFromTo .= '<time datetime="' . $sDate . '">';
        $dateFromTo .= $sDate->formatLocalized($sDateFormat);
        $dateFromTo .= '</time>';
        $dateFromTo .= ' ' . trans('events::global.to') . ' ';
        $dateFromTo .= '<time datetime="' . $eDate . '">';
        $dateFromTo .= $eDate->formatLocalized($dateFormat);
        $dateFromTo .= '</time>';

        return $dateFromTo;

    }
}
