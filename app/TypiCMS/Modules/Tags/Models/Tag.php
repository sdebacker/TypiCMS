<?php namespace TypiCMS\Modules\Tags\Models;

use TypiCMS\Models\Base;

class Tag extends Base {

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
     * Define a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->morphedByMany('TypiCMS\Modules\Projects\Models\Project', 'taggable');
    }

}