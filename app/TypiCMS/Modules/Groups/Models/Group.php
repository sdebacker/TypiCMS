<?php namespace TypiCMS\Modules\Groups\Models;

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;

class Group extends SentryGroupModel {

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'groups';

}
