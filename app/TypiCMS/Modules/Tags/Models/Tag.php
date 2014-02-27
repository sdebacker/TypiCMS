<?php namespace TypiCMS\Modules\Tags\Models;

use TypiCMS\Models\Base;

class Tag extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';



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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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