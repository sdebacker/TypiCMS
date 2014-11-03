<?php
namespace TypiCMS\Modules\History\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\History\Repositories\HistoryInterface;

class AdminController extends AdminSimpleController
{

    public function __construct(HistoryInterface $history)
    {
        parent::__construct($history);
        $this->title['parent'] = trans_choice('history::global.history', 2);
    }
}
