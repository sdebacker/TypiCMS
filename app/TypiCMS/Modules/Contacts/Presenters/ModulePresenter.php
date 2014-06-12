<?php
namespace TypiCMS\Modules\Contacts\Presenters;

use Route;
use Config;
use Exception;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Format creation date
     * 
     * @return String
     */
    public function createdAt()
    {
        return $this->entity->created_at->format('d.m.Y');
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
        // If model is offline or there is no translation
        $routeName = substr($routeName, 0, strrpos($routeName, '.'));
        try { // Does this public route exists ?
            return route($routeName);
        } catch (Exception $e) {
            if (Config::get('app.locale_in_url')) {
                return $lang;
            }
            return '/';
        }
    }
}
