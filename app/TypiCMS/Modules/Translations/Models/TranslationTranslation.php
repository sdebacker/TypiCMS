<?php
namespace TypiCMS\Modules\Translations\Models;

use Eloquent;

class TranslationTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Translations\Models\Translation');
    }
}
