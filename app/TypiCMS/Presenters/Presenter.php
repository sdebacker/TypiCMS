<?php
namespace TypiCMS\Presenters;

use Route;
use Config;

use Exception;

use Croppa;

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
                    return route(
                        $routeName,
                        array(
                            $this->entity->category->translate($lang)->slug,
                            $this->entity->translate($lang)->slug
                        )
                    );
                }
                return route($routeName, $this->entity->translate($lang)->slug);
            } catch (Exception $e) {
                if (Config::get('app.locale_in_url')) {
                    return $lang;
                }
                return '/';
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
            if (Config::get('app.locale_in_url')) {
                return $lang;
            }
            return '/';
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

    /**
     * Return a resized or cropped image
     * 
     * @param  int $width      width of image, null for auto
     * @param  int $height     height of image, null for auto
     * @param  array $options  see Croppa doc for options (https://github.com/BKWLD/croppa)
     * @param  string $field   field name
     * @return string          HTML markup of an image
     */
    public function thumb($width = null, $height = null, array $options = array(), $field = 'image')
    {
        $uploadDir = '/uploads';
        $file = $uploadDir . '/' . $this->entity->getTable() . '/' . $this->entity->$field;
        if (! is_file(public_path() . $file)) {
            $file = $uploadDir . '/img-not-found.png';
        }
        $src = Croppa::url($file, $width, $height, $options);
        return '<img class="img-responsive" src="' . $src . '" alt="">';
    }

    /**
     * Return an icon and file name
     * 
     * @param  int $size       size of the icon
     * @param  string $field   field name
     * @return string          HTML markup of an image
     */
    public function icon($size = 2, $field = 'document')
    {
        $uploadDir = '/uploads';
        $file = $uploadDir . '/' . $this->entity->getTable() . '/' . $this->entity->$field;
        if (! is_file(public_path() . $file)) {
            $file = $uploadDir . '/img-not-found.png';
        }
        $html = '<div class="doc">';
        $html .= '<span class="text-center fa fa-file-text-o fa-' . $size . 'x"></span>';
        $html .= '<a href="' . $file . '">';
        $html .= $this->entity->$field;
        $html .= '</a>';
        $html .= '</div>';
        return $html;
    }
}
