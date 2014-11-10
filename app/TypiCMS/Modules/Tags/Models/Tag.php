<?php
namespace TypiCMS\Modules\Tags\Models;

use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;
use TypiCMS\Traits\Historable;

class Tag extends Base
{

    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Tags\Presenters\ModulePresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'tag',
        'slug',
    );

    protected $appends = [];

    /**
     * The default route for admin side.
     *
     * @var string
     */
    protected $route = 'tags';

    /**
     * Define a many-to-many polymorphic relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function projects()
    {
        return $this->morphedByMany('TypiCMS\Modules\Projects\Models\Project', 'taggable');
    }
}
