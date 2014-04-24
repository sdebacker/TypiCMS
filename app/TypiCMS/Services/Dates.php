<?php
namespace TypiCMS\Services;

use Carbon\Carbon;

class Dates
{
    /**
     * Concat two dates
     *
     * @param string $startingDate
     * @param string $endingDate
     * @return string
     */
    public static function concat($startingDate, $endingDate)
    {

        $startingDateArray = explode('-', $startingDate);
        $endingDateArray = explode('-', $endingDate);
        $endingDateFormat = '%A %d %B %Y';

        if ($startingDate == $endingDate) {
            $startingDateFormat = '%A %d %B %Y';

            return Carbon::createFromFormat('Y-m-d', $startingDate)->formatLocalized($startingDateFormat);
        }

        if ($startingDateArray[1] == $endingDateArray[1]) {
            // mois égaux
            $startingDateFormat = '%A %d';
        } elseif ($startingDateArray[0] == $endingDateArray[0]) {
            // annee égales
            $startingDateFormat = '%A %d %B';
        } else {
            $startingDateFormat = '%A %d %B %Y';
        }

        return Carbon::createFromFormat('Y-m-d', $startingDate)
            ->formatLocalized($startingDateFormat) . ' to ' . Carbon::createFromFormat('Y-m-d', $endingDate)
            ->formatLocalized($endingDateFormat);

    }
}
