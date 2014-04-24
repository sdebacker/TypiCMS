<?php
namespace TypiCMS\Presenters;

use Input;
use Route;
use ArrayAccess;

use Carbon\Carbon;

abstract class AbstractPresenter implements ArrayAccess
{

    /**
    * The object to present
    *
    * @var mixed
    */
    protected $object;

    /**
    * Inject the object to be presented
    *
    * @param mixed
    */
    public function set($object)
    {
        $this->object = $object;
    }

    /**
    * Check to see if there is a presenter
    * method. If not pass to the object
    *
    * @param string $key
    */
    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }

        return $this->object->$key;
    }

    /**
    * Check to see if the offset exists
    * on the current object
    *
    * @param string $key
    * @return boolean
    */
    public function offsetExists($key)
    {
        return isset($this->object[$key]);
    }

    /**
    * Retrieve the key from the object
    * as if it were an array
    *
    * @param string $key
    * @return boolean
    */
    public function offsetGet($key)
    {
        return $this->object[$key];
    }

    /**
    * Set a property on the object
    * as if it were any array
    *
    * @param string $key
    * @param mixed $value
    */
    public function offsetSet($key, $value)
    {
        $this->object[$key] = $value;
    }

    /**
    * Unset a key on the object
    * as if it were an array
    *
    * @param string $key
    */
    public function offsetUnset($key)
    {
        unset($this->object[$key]);
    }

    /**
    * Return the model
    *
    * @return string
    */
    public function object()
    {
        return $this->object;
    }

    /**
    * Online / Offline switches
    *
    * @return string
    */
    public function status()
    {
        $class = ($this->object->status) ? 'online' : 'offline' ;

        return '<span class="switch ' . $class . '">' . trans('global.En ligne/Hors ligne') . '</span>';
    }

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        return '<input type="checkbox" value="' . $this->object->id . '">';
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function edit()
    {
        $url = route('admin.' . $this->object->route . '.edit', $this->object->id);
        return '<a class="btn btn-default btn-xs" href="' . $url .'">' . trans('global.Edit') . '</a>';
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function titleAnchor()
    {
        $url = route('admin.' . $this->object->route . '.edit', $this->object->id);
        return '<a href="' . $url . '">' . $this->object->title . '</a>';
    }

    /**
    * Files in list
    *
    * @return string
    */
    public function countFiles()
    {
        $nbFiles = count($this->object->files);
        $label = $nbFiles ? 'label-success' : 'label-default' ;
        $url = route('admin.' . $this->object->route . '.files.index', $this->object->id);
        $html[] = '<a class="label ' . $label . '" href="' . $url . '">';
        $html[] = $nbFiles;
        $html[] = '</a>';

        return implode("\r\n", $html);
    }

    public function getTable()
    {
        return $this->object->getTable();
    }

    public function publicUri($lang)
    {
        $routeName = $lang . strstr(Route::current()->getName(), '.');
        $routeName = preg_replace('/\.edit$/', '.slug', $routeName);
        // if model is translated and is online
        if (isset($this->object->$lang->slug) and $this->object->$lang->status) {
            return route($routeName, $this->object->$lang->slug);
        }
        $routeName = substr($routeName, 0, strrpos($routeName, '.'));
        return route($routeName);
    }

    public function dateOrNow($date, $format)
    {
        $date = $this->object->$date ? : Carbon::now() ;
        return $date->format($format);
    }
}
