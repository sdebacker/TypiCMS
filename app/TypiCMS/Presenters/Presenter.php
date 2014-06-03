<?php
namespace TypiCMS\Presenters;

use Route;

use Exception;

use Carbon\Carbon;

abstract class Presenter
{

    /**
     * @var mixed
     */
    protected $entity;

    /**
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Allow for property-style retrieval
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }

    /**
    * Online / Offline switches
    *
    * @return string
    */
    public function status()
    {
        $class = ($this->entity->status) ? 'online' : 'offline' ;

        return '<span class="switch ' . $class . '">' . trans('global.En ligne/Hors ligne') . '</span>';
    }

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        return '<input type="checkbox" value="' . $this->entity->id . '">';
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function edit()
    {
        $url = route('admin.' . $this->entity->route . '.edit', $this->entity->id);
        return '<a class="btn btn-default btn-xs" href="' . $url .'">' . trans('global.Edit') . '</a>';
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function titleAnchor()
    {
        $url = route('admin.' . $this->entity->route . '.edit', $this->entity->id);
        return '<a href="' . $url . '">' . $this->entity->title . '</a>';
    }

    /**
     * Get the front end url from the current back end url
     * 
     * @param  string $lang
     * @return string url
     */
    public function publicUri($lang)
    {
        $routeName = $lang . strstr(Route::current()->getName(), '.');
        $routeName = preg_replace('/\.edit$/', '.slug', $routeName);
        // If model is translated and is online
        if (isset($this->entity->translate($lang)->slug) and $this->entity->translate($lang)->status) {
            try { // Does this public route exists ?
                if ($this->entity->category) { // there is a category
                    return route($routeName, array($this->entity->category->translate($lang)->slug, $this->entity->translate($lang)->slug));
                }
                return route($routeName, $this->entity->translate($lang)->slug);
            } catch (Exception $e) {
                return $lang;
            }
        }
        // If model is offline or there is no translation
        $routeName = substr($routeName, 0, strrpos($routeName, '.'));
        try { // Does this public route exists ?
            if ($this->entity->category) { // there is a category
                return route($routeName, $this->entity->category->translate($lang)->slug);
            }
            return route($routeName);
        } catch (Exception $e) {
            return $lang;
        }
    }

    /**
     * Return resource's date or curent date if empty
     * 
     * @param  string $fieldname
     * @param  string $format date format
     * @return Carbon
     */
    public function dateOrNow($fieldname, $format)
    {
        $date = $this->entity->$fieldname ? : Carbon::now() ;
        return $date->format($format);
    }
}
