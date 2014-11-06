<?php
namespace TypiCMS\Modules\Categories\Models;

use TypiCMS\Models\BaseTranslation;

class CategoryTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Categories\Models\Category', 'category_id');
    }
}
