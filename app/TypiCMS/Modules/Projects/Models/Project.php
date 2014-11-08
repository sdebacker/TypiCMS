<?php
namespace TypiCMS\Modules\Projects\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class Project extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Projects\Presenters\ModulePresenter';

    protected $fillable = array(
        'category_id',
        'image',
        // Translatable fields
        'title',
        'slug',
        'status',
        'summary',
        'body',
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
        'summary',
        'body',
    );

    /**
     * List of fields that are file.
     *
     * @var array
     */
    public $attachments = array(
        'image',
    );

    protected $appends = ['status', 'title', 'thumb', 'category_name'];

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'projects';

    /**
     * Relation
     */
    public function category()
    {
        return $this->belongsTo('TypiCMS\Modules\Categories\Models\Category');
    }

    /**
     * Get name of the category from category table
     * and append it to main model attributes
     * @return string title
     */
    public function getCategoryNameAttribute()
    {
        if ($this->category) {
            return $this->category->title;
        }
        return null;
    }
}
