<?php
namespace TypiCMS\Modules\Events\Models;

use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;
use TypiCMS\Traits\Historable;

class Event extends Base
{

    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Events\Presenters\ModulePresenter';

    protected $dates = array('start_date', 'end_date');

    protected $fillable = array(
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'image',
        // Translatable columns
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
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = array(
        'image',
    );
}
