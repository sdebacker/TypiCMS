<?php
namespace TypiCMS\Modules\Events\Controllers;

use TypiCMS\Controllers\BaseAdminController;
use TypiCMS\Modules\Events\Repositories\EventInterface;
use TypiCMS\Modules\Events\Services\Form\EventForm;

class AdminController extends BaseAdminController
{

    public function __construct(EventInterface $event, EventForm $eventform)
    {
        parent::__construct($event, $eventform);
        $this->title['parent'] = trans_choice('events::global.events', 2);
    }
}
