<?php
namespace TypiCMS\Modules\Groups\Models;

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;
use TypiCMS\Presenters\PresentableTrait;
use TypiCMS\Traits\Historable;

class Group extends SentryGroupModel
{

    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Groups\Presenters\ModulePresenter';

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'groups';
}
