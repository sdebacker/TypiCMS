<?php
namespace TypiCMS\Presenters;

use Route;

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
    function __construct($entity)
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
        if (method_exists($this, $property))
        {
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
    * Files in list
    *
    * @return string
    */
    public function countFiles()
    {
        $nbFiles = count($this->entity->files);
        $label = $nbFiles ? 'label-success' : 'label-default' ;
        $url = route('admin.' . $this->entity->route . '.files.index', $this->entity->id);
        $html[] = '<a class="label ' . $label . '" href="' . $url . '">';
        $html[] = $nbFiles;
        $html[] = '</a>';

        return implode("\r\n", $html);
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
        // if model is translated and is online
        if (isset($this->entity->$lang->slug) and $this->entity->$lang->status) {
            return route($routeName, $this->entity->$lang->slug);
        }
        $routeName = substr($routeName, 0, strrpos($routeName, '.'));
        return route($routeName);
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
