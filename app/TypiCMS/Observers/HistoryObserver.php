<?php
namespace TypiCMS\Observers;

class HistoryObserver
{

    public function created($model)
    {
        \Log::info('created');
    }

    public function updated($model)
    {
        \Log::info('updated');
    }
}
