<?php
namespace TypiCMS\Modules\Partners\Models;

use TypiCMS\Models\BaseTranslation;

class PartnerTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Partners\Models\Partner', 'partner_id');
    }
}
