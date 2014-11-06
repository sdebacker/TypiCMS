<?php
namespace TypiCMS\Modules\Menulinks\Models;

use Eloquent;

class MenulinkTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function menulink()
    {
        return $this->belongsTo('TypiCMS\Modules\Menulinks\Models\Menulink');
    }
    public function owner()
    {
        return $this->menulink();
    }
}
