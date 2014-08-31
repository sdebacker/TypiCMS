<?php
namespace TypiCMS\Modules\Contacts\Presenters;

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
