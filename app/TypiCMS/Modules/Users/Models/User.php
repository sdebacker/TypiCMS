<?php
namespace TypiCMS\Modules\Users\Models;

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel
{

    use \TypiCMS\Presenters\PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Users\Presenters\UserPresenter';

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'users';

    /**
     * lists
     */
    public static $order = 'email';
    public static $direction = 'asc';
}
