<?php
namespace TypiCMS\Presenters;

use Input;
use ArrayAccess;

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
        return '<a class="btn btn-default btn-xs" href="' . route('admin.' . $this->object->route . '.edit', $this->object->id).'">' . trans('global.Edit') . '</a>';
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function titleAnchor()
    {
        return '<a href="' . route('admin.' . $this->object->route . '.edit', $this->object->id).'">' . $this->object->title . '</a>';
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
        $html[] = '<a class="label ' . $label . '" href="' . route('admin.' . $this->object->route . '.files.index', $this->object->id) . '">';
        $html[] = $nbFiles;
        $html[] = '</a>';

        return implode("\r\n", $html);
    }

    public function getTable()
    {
        return $this->object->getTable();
    }

}
