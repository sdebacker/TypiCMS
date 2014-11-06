<?php
namespace TypiCMS\Modules\Menus\Models;

use Eloquent;

class MenuTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Models\Menu');
    }
}
