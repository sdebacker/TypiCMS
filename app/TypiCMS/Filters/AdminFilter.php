<?php
namespace TypiCMS\Filters;

use App;
use Lang;
use Route;
use Input;
use Sentry;
use Config;
use Session;
use Request;
use Redirect;
use Response;

/**
* Public filter
*/
class AdminFilter
{

    // Set App and Translator locale
    public function setLocale()
    {
        // If we have a query string like ?locale=xx
        if (Input::get('locale')) {
            // If locale is present in app.locales…
            if (in_array(Input::get('locale'), Config::get('app.locales'))) {
                // …store locale in session
                Session::put('locale', Input::get('locale'));
            }
        }
        // Set app.locale
        Config::set('app.locale', Session::get('locale', Config::get('app.locale')));
        // Set Translator locale to typicms.adminLocale config
        Lang::setLocale(Config::get('typicms.adminLocale'));
    }

    public function auth()
    {
        // check user is connected
        if (! Sentry::check()) {
            if (Request::ajax()) {
                return Response::make('Unauthorized', 401);
            }
            return Redirect::guest(route('login'));
        }
        $route = Route::getCurrentRoute()->getName();
        $user = Sentry::getUser();
        // Debugbar::addMessage($user->getPermissions(), 'users permissions');
        // Debugbar::addMessage($user->getMergedPermissions(), 'users merged permissions');
        // Debugbar::addMessage($route, 'route');
        if (! $user->hasAccess($route)) {
            App::abort(403);
        }
    }
}
