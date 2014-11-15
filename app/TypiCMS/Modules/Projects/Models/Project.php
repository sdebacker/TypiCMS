<?php
namespace TypiCMS\Modules\Projects\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;
use TypiCMS\Traits\Historable;

class Project extends Base
{

    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Projects\Presenters\ModulePresenter';

    protected $fillable = array(
        'category_id',
        'image',
        // Translatable columns
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
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = array(
        'image',
    );

    protected $appends = ['status', 'title', 'thumb', 'category_name'];

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
