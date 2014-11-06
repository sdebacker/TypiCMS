<?php
namespace TypiCMS\Modules\Projects\Models;

use Eloquent;

class ProjectTranslation extends Eloquent
{
    protected $touches = ['owner'];

    /**
     * get the parent model
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Projects\Models\Project');
    }
}
