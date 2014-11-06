<?php
namespace TypiCMS\Modules\Blocks\Models;

use Eloquent;

class BlockTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Blocks\Models\Block');
    }
}
