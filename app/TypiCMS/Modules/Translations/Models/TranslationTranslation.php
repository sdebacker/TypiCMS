<?php
namespace TypiCMS\Modules\Translations\Models;

use TypiCMS\Models\BaseTranslation;

class TranslationTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Translations\Models\Translation', 'translation_id');
    }
}
