<?php
namespace TypiCMS\Modules\Files\Models;

use Eloquent;

class FileTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Files\Models\File');
    }
}
