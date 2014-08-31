<?php
namespace TypiCMS\Modules\News\Models;

use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class News extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\News\Presenters\ModulePresenter';

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
     * Transform date in Carbon object
     *
     * @param string $value date string
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value);
    }

    /**
     * A news has many galleries.
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
}
