<?php
namespace TypiCMS\Modules\Pages\Models;

use App;
use Config;
use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\NestedCollection;
use TypiCMS\Presenters\PresentableTrait;

class Page extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Pages\Presenters\ModulePresenter';

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
     * Get public uri
     *
     * @return string
     */
    public function getPublicUri($preview = false, $index = false, $lang = null)
    {
        $lang = $lang ? : App::getlocale() ;
        $indexUri = Config::get('app.locale_in_url') ? '/'.$lang : '/' ;

        if ($index || $this->is_home) {
            return $indexUri;
        }

        // If model is offline and we are not in preview mode
        if (! $preview && ! $this->translate($lang)->status) {
            return $indexUri;
        }

        if ($this->translate($lang)->uri) {
            return '/' . $this->translate($lang)->uri;
        }
    }

    /**
     * Relations
     */
    public function menulinks()
    {
        return $this->hasMany('TypiCMS\Modules\Menulinks\Models\Menulink');
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
     * @return NestedCollection object
     */
    public function newCollection(array $models = array())
    {
        return new NestedCollection($models);
    }

    /**
     * A page has many galleries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function galleries()
    {
        return $this->morphToMany('TypiCMS\Modules\Galleries\Models\Gallery', 'galleryable')
            ->withPivot('position')
            ->orderBy('position')
            ->withTimestamps();
    }

    /**
     * Observers
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function (Page $model) {
            // set is_home = 0 on previous homepage
            if ($model->is_home) {
                static::where('is_home', 1)
                    ->update(array('is_home' => 0));
            }
        });

        static::updating(function (Page $model) {
            // set is_home = 0 on previous homepage
            if ($model->is_home) {
                static::where('is_home', 1)
                    ->where('id', '!=', $model->id)
                    ->update(array('is_home' => 0));
            }
        });
    }
}
