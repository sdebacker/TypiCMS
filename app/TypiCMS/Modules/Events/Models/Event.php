<?php namespace TypiCMS\Modules\Events\Models;

use TypiCMS\Models\Base;

use Input;
use Carbon\Carbon;

class Event extends Base {

    use \Dimsav\Translatable\Translatable;

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
     * Items per page
     *
     * @var string
     */
    public $itemsPerPage = 25;


    /**
     * Relations
     */
    public function files()
    {
        return $this->morphMany('TypiCMS\Modules\Files\Models\File', 'fileable');
    }


    /**
     * Accessors
     *
     * @return string
     */
    public function getStartDateAttribute($value)
    {
        if ($value == '0000-00-00') return;
        return Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
    }

    public function getEndDateAttribute($value)
    {
        if ($value == '0000-00-00') return;
        return Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
    }


    /**
     * Observers
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            // transform dates to sql
            if (Input::get('start_date')) {
                $model->start_date = Carbon::createFromFormat('d.m.Y', Input::get('start_date'))->toDateString();
            }
            if (Input::get('end_date')) {
                $model->end_date = Carbon::createFromFormat('d.m.Y', Input::get('end_date'))->toDateString();
            }
        });

    }

}