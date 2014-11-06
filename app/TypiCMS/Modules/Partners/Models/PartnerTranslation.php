<?php
namespace TypiCMS\Modules\Partners\Models;

use Eloquent;

class PartnerTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Partners\Models\Partner');
    }
}
