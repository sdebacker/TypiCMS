<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

App::missing(function($exception)
{
	return Response::view('errors.missing', array(), 404);
});

App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $exception)
{
	return Response::view('errors.missing', array(), 404);
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('auth.admin', function()
{
	if ( ! Sentry::check()) {
		return Redirect::guest(route('login'));
	}
});


/*
|--------------------------------------------------------------------------
| Cache Filter
|--------------------------------------------------------------------------
*/

Route::filter('cache', function($route, $request, $response = null)
{
	// dd(Config::get('typicms.cachepublic'));
	if ( ! Sentry::check() and Config::get('typicms.cachepublic')) { // no cache if connected
		$key = 'route-'.Str::slug(Request::fullUrl());
		if (is_null($response) && Cache::section('public')->has($key)) {
			return Cache::section('public')->get($key);
		} else if ( ! is_null($response) && ! Cache::section('public')->has($key)) {
			Cache::section('public')->put($key, $response->getContent(), 30);
		}
	}
});


/*
|--------------------------------------------------------------------------
| Cache Clear Filter
|--------------------------------------------------------------------------
*/

Route::filter('cache.clear', function()
{
	Cache::section('public')->flush();
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});