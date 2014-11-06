<?php
namespace TypiCMS\Modules\Events\Models;

use Eloquent;

class EventTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Events\Models\Event');
    }
}
