<?php
namespace TypiCMS\Models;

use App;
use Route;
use Input;
use Mockery;
use Eloquent;

/**
 * @method string order($query)
 * @method string whereHasOnlineTranslation($query)
 * @method string files($query, $all)
 * @method string order($query)
 * @method string withOnlineGalleries($query)
 */
abstract class Base extends Eloquent {
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
     * Get preview uri
     *
     * @return null|string string or null
     */
    public function previewUri()
    {
        if (! $this->id) {
            return null;
        }
        return $this->getPublicUri(true);
    }

    /**
     * Get public uri
     *
     * @return string|null string or null
     */
    public function getPublicUriIndex()
    {
        $uri = $this->getPublicUri(false, true);
        return $uri;
    }

    /**
     * Get public uri
     *
     * @return string|null string or null
     */
    public function getPublicUri($preview = false, $index = false, $lang = null)
    {
        $lang = $lang ? : App::getlocale() ;

        // Route parameters
        $parameters = [$this->translate($lang)->slug];

        // If index of module is asked
        if ($index) {
            $parameters = [null];
        }

        // If model is offline and we are not in preview mode
        if (! $preview and ! $this->translate($lang)->status) {
            $parameters = [null];
        }

        $route = array();

        // Route name
        $route['lang'] = $lang;
        $route['table'] = $this->getTable();

        // if there is a category
        if (method_exists($this, 'category')) {
            if ($this->category) {
                array_unshift($parameters, $this->category->translate($lang)->slug);
                $route['category'] = 'categories';
            }
        }
        $route['suffix'] = 'slug';
        $routeName = implode('.', $route);

        // Does route exists ?
        if (Route::has($routeName)) {
            return route($routeName, $parameters);
        }
        return null;
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
        return $query->with(
            array('files' => function ($query) use ($all) {
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
        return $query->whereHas(
            'translations',
            function ($query) {
                if (! Input::get('preview')) {
                    $query->where('status', 1);
                }
                $query->where('locale', App::getLocale());
                $query->where('slug', '!=', '');
            }
        );
    }

    /**
     * Get online galleries
     *
     * @param $query
     * @return Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeWithOnlineGalleries($query)
    {
        if (! method_exists($this, 'galleries')) {
            return $query;
        }
        return $query->with(
            array(
                'galleries.translations',
                'galleries.files.translations',
                'galleries' => function ($query) {
                    $query->whereHas(
                        'translations',
                        function ($query) {
                            $query->where('status', 1);
                            $query->where('locale', App::getLocale());
                        }
                    );
                }
            )
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
}
