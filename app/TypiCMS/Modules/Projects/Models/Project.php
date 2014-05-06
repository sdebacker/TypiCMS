<?php
namespace TypiCMS\Modules\Projects\Models;

use TypiCMS\Models\Base;

class Project extends Base
{

    use \Dimsav\Translatable\Translatable;
    use \TypiCMS\Presenters\PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Projects\Presenters\ProjectPresenter';

    protected $fillable = array(
        'category_id',
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
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'projects';

    /**
     * Lists
     */
    public $order = 'id';
    public $direction = 'desc';

    /**
     * Relation
     */
    public function category()
    {
        return $this->belongsTo('TypiCMS\Modules\Categories\Models\Category');
    }

    /**
     * Define a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->morphToMany('TypiCMS\Modules\Tags\Models\Tag', 'taggable')->withTimestamps();
    }

    /**
     * Define a many-to-many polymorphic relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->morphToMany('TypiCMS\Modules\Files\Models\File', 'fileable')->withTimestamps();
    }
}
