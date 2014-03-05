<?php namespace TypiCMS\Modules\Events\Presenters;

use Carbon\Carbon;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class EventPresenter extends AbstractPresenter implements Presentable {

	public function date_from_to()
	{
		$sDate = Carbon::parse($this->object->start_date);
		$eDate = Carbon::parse($this->object->end_date);
		$dateFormat = '%d %B %Y';
		$sDateFormat = $dateFormat;
		$sDateSQL = $sDate->format('Y-m-d');
		$eDateSQL = $eDate->format('Y-m-d');
		if ($sDate == $eDate) {
			return ucfirst(trans('events::global.on')) . ' <time datetime="' . $sDateSQL . '">' . $sDate->formatLocalized($dateFormat) . '</time>';
		}
		if ($sDate->format('Y') == $eDate->format('Y')) {
			$sDateFormat = '%d %B';
			if ($sDate->format('m') == $eDate->format('m')) {
				$sDateFormat = '%d';
			}
		}
		return ucfirst(trans('events::global.from')) . ' <time datetime="' . $sDateSQL . '">' . $sDate->formatLocalized($sDateFormat) . '</time> ' . trans('events::global.to') . ' <time datetime="' . $eDateSQL . '">' . $eDate->formatLocalized($dateFormat) . '</time>';
	}
}
