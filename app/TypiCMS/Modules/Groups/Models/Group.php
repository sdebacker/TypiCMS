<?php
namespace TypiCMS\Modules\Groups\Models;

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;

class Group extends SentryGroupModel
{

    use \TypiCMS\Presenters\PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Groups\Presenters\GroupPresenter';

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'groups';
}
