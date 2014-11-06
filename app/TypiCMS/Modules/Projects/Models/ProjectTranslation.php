<?php
namespace TypiCMS\Modules\Projects\Models;

use TypiCMS\Models\BaseTranslation;

class ProjectTranslation extends BaseTranslation
{
    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Projects\Models\Project', 'project_id');
    }
}
