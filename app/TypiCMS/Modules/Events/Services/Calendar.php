<?php
namespace TypiCMS\Modules\Events\Services;

use Eluceo\iCal\Component\Calendar as ElucleoCalendar;
use Eluceo\iCal\Component\Event as ElucleoEvent;
use TypiCMS\Modules\Events\Models\Event;

class Calendar
{
    protected $iCalendar;
    protected $iEvent;

    public function __construct(ElucleoCalendar $iCalendar, ElucleoEvent $iEvent)
    {
        $this->iCalendar = $iCalendar;
        $this->iEvent = $iEvent;
    }

    /**
     * add an event to the calendar
     *
     * @param Event $model
     */
    public function add(Event $model)
    {
        $this->iEvent->setNoTime(true);

        $start_date = $model->start_date;
        $end_date   = $model->end_date;
        if ($model->start_time) {
            $time = explode(':', $model->start_time);
            $start_date = $start_date->setTime($time[0], $time[1]);
            $this->iEvent->setNoTime(false);
        }
        if ($model->end_time) {
            $time = explode(':', $model->end_time);
            $end_date = $end_date->setTime($time[0], $time[1]);
            $this->iEvent->setNoTime(false);
        } else {
            $end_date = $end_date->addDay();
        }
        // fill event
        $this->iEvent->setDtStart($start_date);
        $this->iEvent->setDtEnd($end_date);
        $this->iEvent->setSummary($model->title);
        $this->iEvent->setUseTimezone(true);
        // add it to the calendar
        $this->iCalendar->addComponent($this->iEvent);
    }

    /**
     * Render .ics calendar
     *
     * @param $model
     */
    public function render()
    {
        return $this->iCalendar->render();
    }
}
