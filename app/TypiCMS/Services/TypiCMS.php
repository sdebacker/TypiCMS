<?php
namespace TypiCMS\Services;

use HTML;
use Route;
use Config;

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
            return $this->model->publicUri($lang);
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
            return $this->model->publicUri($lang);
        }
        $routeArray = explode('.', Route::current()->getName());
        $routeArray[0] = $lang;
        array_pop($routeArray);
        $route = implode('.', $routeArray);

        if (Route::getRoutes()->hasNamedRoute($route)) {
            return route($route);
        }
        return $lang;
    }

}
