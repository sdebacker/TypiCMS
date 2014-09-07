<?php
namespace TypiCMS\Filters;

use App;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Config;
use Notification;
use Redirect;
use Request;
use Response;
use Sentry;

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
     * Visitor is allowed to visit public website ?
     */
    public function publicAccess()
    {
        if (! Config::get('typicms.authPublic')) {
            return;
        }
        return $this->auth();
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
    public function hasAccess(
        \Illuminate\Routing\Route $route,
        \Illuminate\Http\Request $request,
        $value = 'chose'
    ) {
        $value = ($value) ? : $route->getName() ;
        try {
            $user = Sentry::getUser();
            if( ! $user->hasAccess($value)) {
                App::abort(403);
            }
        } catch (UserNotFoundException $e) {
            Notification::error($e->getMessage() . '\n' .  $request->fullUrl());
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
