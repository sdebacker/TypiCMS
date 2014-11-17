<?php
namespace TypiCMS\Modules\Events\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Return start_date formated as d.m.Y
     *
     * @return string
     */
    public function startDate()
    {
        return $this->entity->start_date->format('d.m.Y');
    }

    /**
     * Return end_date formated as d.m.Y
     *
     * @return string
     */
    public function endDate()
    {
        return $this->entity->end_date->format('d.m.Y');
    }

    /**
     * Return start_date formated as H:i
     *
     * @return string
     */
    public function startTime()
    {
        if (! $this->entity->start_date) {
            return '';
        }
        return $this->entity->start_date->format('H:i');
    }

    /**
     * Return end_date formated as H:i
     *
     * @return string
     */
    public function endTime()
    {
        if (! $this->entity->end_date) {
            return '';
        }
        return $this->entity->end_date->format('H:i');
    }

    /**
     * concat start and end date
     * without repeating common month and year
     *
     * @return string html data
     */
    public function dateFromTo()
    {
        $sDate = $this->entity->start_date;
        $eDate = $this->entity->end_date;
        $dateFormat = '%d %B %Y';
        $sDateFormat = $dateFormat;
        if ($sDate == $eDate) {
            return ucfirst(trans('events::global.on')) .
                ' <time datetime="' . $sDate . '">' .
                $sDate->formatLocalized($dateFormat) .
                '</time>';
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

    /**
     * concat start and end time
     *
     * @return string
     */
    public function timeFromTo()
    {
        $timeFromTo = $this->entity->start_time;
        $eTime = $this->entity->end_time;
        if ($eTime) {
            $timeFromTo .= ' - ' . $eTime;
        }
        return $timeFromTo;

    }
}
