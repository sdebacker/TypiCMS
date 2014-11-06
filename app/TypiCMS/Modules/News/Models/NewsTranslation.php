<?php
namespace TypiCMS\Modules\News\Models;

use Eloquent;

class NewsTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\News\Models\News');
    }
}
