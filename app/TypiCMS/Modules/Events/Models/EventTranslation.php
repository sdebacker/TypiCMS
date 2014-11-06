<?php
namespace TypiCMS\Modules\Events\Models;

use TypiCMS\Models\BaseTranslation;

class EventTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Events\Models\Event', 'event_id');
    }
}
