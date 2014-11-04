<?php
namespace TypiCMS\Modules\Users\Models;

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;
use TypiCMS\Presenters\PresentableTrait;
use TypiCMS\Traits\Historable;

class User extends SentryUserModel
{

    use Historable;
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
