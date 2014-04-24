<?php
namespace TypiCMS\Modules\Pages\Models;

use TypiCMS\Models\Base;
use TypiCMS\NestedCollection;

use Input;

class Page extends Base
{

    use \Dimsav\Translatable\Translatable;

    protected $fillable = array(
        'meta_robots_no_index',
        'meta_robots_no_follow',
        'position',
        'parent',
        'rss_enabled',
        'comments_enabled',
        'is_home',
        'css',
        'js',
        'template',
        // Translatable fields
        'title',
        'slug',
        'uri',
        'status',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'slug',
        'uri',
        'status',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description',
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'pages';

    /**
     * lists
     */
    public $order = 'position';
    public $direction = 'asc';

    /**
     * For nested collection
     *
     * @var array
     */
    public $children = array();

    /**
     * Relations
     */
    public function menulinks()
    {
        return $this->hasMany('TypiCMS\Modules\Menulinks\Models\Menulink');
    }

    public function files()
    {
        return $this->morphMany('TypiCMS\Modules\Files\Models\File', 'fileable');
    }

    /**
     * Scope from
     */
    public function scopeFrom($query, $relid)
    {
        return $query;
    }

    /**
     * Custom collection
     *
     * @return InvoiceCollection object
     */
    public function newCollection(array $models = array())
    {
        return new NestedCollection($models);
    }

    /**
     * Observers
     */
    public static function boot()
    {
        parent::boot();

        $self = __CLASS__;

        static::saving(function ($model) use ($self) {
            // change homepage
            if (Input::get('is_home')) {
                $self::where('is_home', 1)->update(array('is_home' => 0));
            }
        });

    }
}
