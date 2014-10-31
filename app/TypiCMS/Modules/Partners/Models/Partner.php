<?php
namespace TypiCMS\Modules\Partners\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class Partner extends Base
{

    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Partners\Presenters\ModulePresenter';

    protected $fillable = array(
        'image',
        // Translatable fields
        'title',
        'slug',
        'position',
        'homepage',
        'status',
        'website',
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
        'website',
        'body',
    );

    protected $appends = ['status', 'title', 'thumb', 'website'];

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
    public $route = 'partners';

    /**
     * lists
     */
    public $order = 'position';
    public $direction = 'asc';

    /**
     * Get attribute from translation table
     * and append it to main model attributes
     * @return string title
     */
    public function getWebsiteAttribute()
    {
        return $this->website;
    }
}
