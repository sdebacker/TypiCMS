<?php
namespace TypiCMS\Modules\Pages\Models;

use App;
use Config;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use TypiCMS\Models\Base;
use TypiCMS\NestableCollection;
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
        'parent_id',
        'is_home',
        'css',
        'js',
        'template',
        'image',
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

    protected $appends = ['status', 'title', 'thumb', 'uri'];

    /**
     * List of fields that are file.
     *
     * @var array
     */
    public $attachments = array(
        'image',
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
     * Get uri attribute from translation table
     *
     * @return string uri
     */
    public function getUriAttribute($value)
    {
        return $this->uri;
    }

    /**
     * A page can have menulinks
     */
    public function menulinks()
    {
        return $this->hasMany('TypiCMS\Modules\Menulinks\Models\Menulink');
    }

    /**
     * A page can have children
     */
    public function children()
    {
        return $this->hasMany('TypiCMS\Modules\Pages\Models\Page', 'parent_id');
    }

    /**
     * A page can have a parent
     */
    public function parent()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page', 'parent_id');
    }

    /**
     * Pages are nestable
     *
     * @return NestableCollection object
     */
    public function newCollection(array $models = array())
    {
        return new NestableCollection($models, 'parent_id');
    }
}
