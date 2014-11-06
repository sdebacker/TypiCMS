<?php
namespace TypiCMS\Modules\Places\Models;

use Eloquent;

class PlaceTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Places\Models\Place');
    }
}
