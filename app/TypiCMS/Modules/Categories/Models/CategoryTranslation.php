<?php
namespace TypiCMS\Modules\Categories\Models;

use Eloquent;

class CategoryTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Categories\Models\Category');
    }
}
