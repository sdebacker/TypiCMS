<?php
namespace TypiCMS\Modules\Users\Models;

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;
use TypiCMS\Presenters\PresentableTrait;

class User extends SentryUserModel
{

    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Users\Presenters\ModulePresenter';

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
