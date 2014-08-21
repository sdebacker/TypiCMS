<?php
namespace TypiCMS\Modules\Groups\Models;

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;

use TypiCMS\Presenters\PresentableTrait;

class Group extends SentryGroupModel
{

    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Groups\Presenters\ModulePresenter';

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'groups';

    /**
     * Get public uri
     * 
     * @return void
     */
    public function getPublicUri($preview = false)
    {
        return null;
    }
}
