<?php
namespace TypiCMS\Modules\Contacts\Presenters;

use Route;
use Config;
use Exception;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Format creation date
     * 
     * @return String
     */
    public function createdAt()
    {
        return $this->entity->created_at->format('d.m.Y');
    }
}
