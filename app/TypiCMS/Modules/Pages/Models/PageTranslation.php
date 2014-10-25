<?php
namespace TypiCMS\Modules\Pages\Models;

use Eloquent;

class PageTranslation extends Eloquent
{
    /**
     * get the page
     */
    public function page()
    {
        return $this->belongsTo('\TypiCMS\Modules\Pages\Models\Page');
    }
}
