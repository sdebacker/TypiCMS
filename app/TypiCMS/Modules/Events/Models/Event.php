<?php
namespace TypiCMS\Modules\Events\Models;

use TypiCMS\Models\Base;

use Input;
use Carbon\Carbon;

class Event extends Base
{

    use \Dimsav\Translatable\Translatable;
    use \TypiCMS\Presenters\PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Events\Presenters\EventPresenter';

    protected $dates = array('start_date', 'end_date');

    protected $fillable = array(
        'start_date',
        'end_date',
        'start_time',
        'end_time',
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
    public $route = 'events';

    /**
     * lists
     */
    public $order = 'start_date';
    public $direction = 'asc';

    /**
     * Transform start_date in Carbon object
     * 
     * @param string $value date string
     */
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value);
    }

    /**
     * Transform end_date in Carbon object
     * 
     * @param string $value date string
     */
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value);
    }
}
