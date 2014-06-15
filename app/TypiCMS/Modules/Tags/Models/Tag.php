<?php
namespace TypiCMS\Modules\Tags\Models;

use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class Tag extends Base
{

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

    /**
     * The default route for admin side.
     *
     * @var string
     */
    protected $route = 'tags';

    /**
     * lists
     */
    public $order = 'tag';
    public $direction = 'asc';

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
