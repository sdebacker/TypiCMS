<?php
namespace TypiCMS\Modules\Pages\Models;

use Eloquent;

class PageTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function page()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page');
    }
    public function owner()
    {
        return $this->page();
    }
}
