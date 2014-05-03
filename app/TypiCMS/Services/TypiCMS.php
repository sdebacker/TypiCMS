<?php
namespace TypiCMS\Services;

use App;
use HTML;
use Route;
use Config;
use Request;

use Sentry;

/**
* LangSwitcher
*/
class TypiCMS
{
    private $model;

    /**
    * Set model
    *
    * @param Model $model
    */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
    * Build languages menu
    *
    * @param array $attributes
    * @return string
    */
    public function languagesMenu(array $attributes = array())
    {
        $langsArray = $this->buildLangsArray(Config::get('app.locales'));
        return HTML::languagesMenu($langsArray, $attributes);
    }

    /**
    * Build langs array
    *
    * @param array $locales
    * @return array
    */
    private function buildLangsArray(array $locales = array())
    {
        $langsArray = array();
        foreach ($locales as $locale) {
            $langsArray[] = (object) array(
                'lang' => $locale,
                'url' => $this->getTranslatedUrl($locale),
                'class' => Config::get('app.locale') == $locale ? 'active' : ''
            );
        }
        return $langsArray;
    }

    /**
    * Get url from model
    *
    * @param string $lang
    * @return string
    */
    private function getTranslatedUrl($lang)
    {
        if ($this->model) {
            return $this->model->present()->publicUri($lang);
        }
        if ($routeName = Route::current()->getName() != 'root') {
            $routeName = $lang . strstr(Route::current()->getName(), '.');
            if ($routeName == $lang) {
                return $lang;
            }
            return route($routeName);
        }
        return $lang;
    }

    /**
    * Get url from model
    *
    * @param string $lang
    * @return string
    */
    public function getPublicUrl($lang = null)
    {
        $lang = $lang ?: Config::get('app.locale') ;
        if ($this->model) {
            return $this->model->present()->publicUri($lang);
        }
        $routeArray = explode('.', Route::current()->getName());
        $routeArray[0] = $lang;
        array_pop($routeArray);
        $route = implode('.', $routeArray);

        if (Route::getRoutes()->hasNamedRoute($route)) {
            return route($route);
        }
        return '/' . $lang;
    }

    /**
    * Build public link
    *
    * @param array $attributes
    * @return string
    */
    public function publicLink(array $attributes = array())
    {
        $url = $this->getPublicUrl();
        $title = ucfirst(trans('global.view website', array(), null, Config::get('typicms.adminLocale')));
        return HTML::link($url, $title, $attributes);
    }

    /**
    * Build admin link
    *
    * @param array $attributes
    * @return string
    */
    public function adminLink(array $attributes = array())
    {
        $url = route('dashboard');
        $title = ucfirst(trans('global.admin side', array(), null, Config::get('typicms.adminLocale')));
        if ($this->model) {
            $url = route('admin.' . $this->model->route . '.edit', $this->model->id) . '?locale=' . App::getLocale();
            // $title = 'Edit ' . $this->model->title;
        }
        return HTML::link($url, $title, $attributes);
    }

    /**
    * Build admin or public link
    *
    * @param array $attributes
    * @return string
    */
    public function otherSideLink(array $attributes = array())
    {
        if ($this->isAdmin()) {
            return $this->publicLink($attributes);
        }
        return $this->adminLink($attributes);
    }

    /**
    * Build admin or public link
    *
    * @param array $attributes
    * @return string
    */
    public function isAdmin()
    {
        if (Request::segment(1) == 'admin') {
            return true;
        }
        return false;
    }

    
    /**
    * Build admin or public link
    *
    * @param array $attributes
    * @return string
    */
    public function getModules()
    {
        $modules = array();
        if (Sentry::getUser()) {
            foreach (Config::get('app.modules') as $module => $property) {
                if ($property['menu'] and Sentry::getUser()->hasAccess('admin.' . strtolower($module) . '.index')) {
                    $modules[$module] = $property;
                }
            }
        }
        return $modules;
    }
}
