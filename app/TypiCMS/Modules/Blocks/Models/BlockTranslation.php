<?php
namespace TypiCMS\Modules\Blocks\Models;

use TypiCMS\Models\BaseTranslation;

class BlockTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Blocks\Models\Block', 'block_id');
    }
}
