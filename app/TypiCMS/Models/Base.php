<?php
namespace TypiCMS\Models;

use App;
use Cache;
use Input;
use Mockery;
use Eloquent;

abstract class Base extends Eloquent
{

    /**
     * For testing
     */
    public static function shouldReceive()
    {
        $class = class_basename(get_called_class());
        $repo = 'TypiCMS\\Modules\\'.str_plural($class).'\\Repositories\\'.$class.'Interface';
        $mock = Mockery::mock($repo);

        App::instance($repo, $mock);

        return call_user_func_array(array($mock, 'shouldReceive'), func_get_args());
    }

    /**
     * Attach files to model
     *
     * @param $query
     * @param boolean All : all models or online models
     * @return Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFiles($query, $all = false)
    {
        return $query->with(array('files' => function ($query) use ($all) {
                $query->with(array('translations' => function ($query) use ($all) {
                    $query->where('locale', App::getLocale());
                    ! $all and $query->where('status', 1);
                }));
                $query->whereHas('translations', function ($query) use ($all) {
                    $query->where('locale', App::getLocale());
                    ! $all and $query->where('status', 1);
                });
                $query->orderBy('position', 'asc');
            })
        );
    }

    /**
     * Get models that have online non empty translation
     *
     * @param $query
     * @return Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeWhereHasOnlineTranslation($query)
    {
        return $query->whereHas('translations', function ($query) {
                $query->where('status', 1);
                $query->where('locale', App::getLocale());
                $query->where('slug', '!=', '');
            }
        );
    }

    /**
     * Order items according to GET value or model value, default is id asc
     *
     * @param $query
     * @return Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeOrder($query)
    {
        $order = Input::get('order', $this->order) ? : 'id' ;
        $direction = Input::get('direction', $this->direction) ? : 'asc' ;

        return $query->orderBy($order, $direction);
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::created(function($model)
    //     {
    //         Cache::tags('Dashboard')->flush();
    //     });

    //     static::deleted(function($model)
    //     {
    //         $module = ucfirst($model->table);
    //         Cache::tags('Dashboard', $module)->flush();
    //     });

    //     static::saved(function($model)
    //     {
    //         $module = ucfirst($model->table);
    //         Cache::tags($module)->flush();
    //     });

    // }

}
