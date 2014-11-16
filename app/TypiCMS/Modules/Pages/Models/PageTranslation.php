<?php
namespace TypiCMS\Modules\Pages\Models;

use TypiCMS\Models\BaseTranslation;

class PageTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function page()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page');
    }
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page', 'page_id');
    }
}
