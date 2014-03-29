<?php
namespace TypiCMS\Modules\News\Models;

use Input;

use Carbon\Carbon;

use TypiCMS\Models\Base;

class News extends Base
{

    use \Dimsav\Translatable\Translatable;

    protected $dates = array('date');

    protected $fillable = array(
        'date',
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
    public $route = 'news';

    /**
     * lists
     */
    public $order = 'date';
    public $direction = 'desc';

    /**
     * Relations
     */
    public function files()
    {
        return $this->morphMany('TypiCMS\Modules\Files\Models\File', 'fileable');
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value);
    }

}
