<?php
namespace TypiCMS\Modules\News\Models;

use TypiCMS\Models\BaseTranslation;

class NewsTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\News\Models\News', 'news_id');
    }
}
