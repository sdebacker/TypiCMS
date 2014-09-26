<?php
namespace TypiCMS\Modules\Events\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Events\Repositories\EventInterface;
use TypiCMS\Modules\Events\Services\Form\EventForm;

class AdminController extends AdminSimpleController
{

    public function __construct(EventInterface $event, EventForm $eventform)
    {
        parent::__construct($event, $eventform);
        $this->title['parent'] = trans_choice('events::global.events', 2);
    }
}
