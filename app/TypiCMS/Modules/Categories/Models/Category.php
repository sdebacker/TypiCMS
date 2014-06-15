<?php
namespace TypiCMS\Modules\Categories\Models;

use Dimsav\Translatable\Translatable;

use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class Category extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Categories\Presenters\ModulePresenter';

    protected $fillable = array(
        'position',
        // Translatable fields
        'title',
        'slug',
        'status',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'slug',
        'status',
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'categories';

    /**
     * lists
     */
    public $order = 'position';
    public $direction = 'asc';

    /**
     * Relations
     */
    public function projects()
    {
        return $this->hasMany('TypiCMS\Modules\Projects\Models\Project');
    }
}
