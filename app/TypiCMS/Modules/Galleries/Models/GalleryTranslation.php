<?php
namespace TypiCMS\Modules\Galleries\Models;

use Eloquent;

class GalleryTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Galleries\Models\Gallery');
    }
}
