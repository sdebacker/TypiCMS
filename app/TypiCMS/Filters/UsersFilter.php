<?php
namespace TypiCMS\Filters;

use App;
use Config;

/**
* Users filter
*/
class UsersFilter
{

    /**
     * User registration allowed ?
     */
    public function mayRegister()
    {
        if (! Config::get('typicms.register')) {
            App::abort(404);
        }
    }
}
