<?php
namespace TypiCMS\Filters;

use App;
use Config;
use Request;
use Redirect;
use Notification;
use Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

/**
* Users and visitors related filters
*/
class UsersFilter
{

    /**
     * Visitor is allowed to register ?
     */
    public function mayRegister()
    {
        if (! Config::get('typicms.register')) {
            App::abort(404);
        }
    }

    /**
     * User is logged in ?
     */
    public function auth()
    {
        if (! Sentry::check()) {
            if (Request::ajax()) {
                return Response::make('Unauthorized', 401);
            }
            return Redirect::guest(route('login'));
        }
    }

    /**
     * User has access to a route ?
     */
    public function hasAccess($route, $request, $value = null)
    {
        $value = ($value) ? : $route->getName() ;
        try {
            $user = Sentry::getUser();
            // \Debugbar::addMessage($user->getPermissions(), 'users permissions');
            // \Debugbar::addMessage($user->getMergedPermissions(), 'users merged permissions');
            if( ! $user->hasAccess($value)) {
                App::abort(403);
            }
        } catch (UserNotFoundException $e) {
            Notification::error($e->getMessage());
            return Redirect::guest(route('login'));
        }
    }

    /**
     * User belongs to a group ?
     */
    public function inGroup($route, $request, $value)
    {
        try {
            $user = Sentry::getUser();
            $group = Sentry::findGroupByName($value);
            if(! $user->inGroup($group)) {
                App::abort(403);
            }
        } catch (UserNotFoundException $e) {
            Notification::error($e->getMessage());
            return Redirect::guest(route('login'));
        } catch (GroupNotFoundException $e) {
            Notification::error($e->getMessage());
            return Redirect::guest(route('login'));
        }
    }
}
