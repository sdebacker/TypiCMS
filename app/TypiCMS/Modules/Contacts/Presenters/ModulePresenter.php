<?php
namespace TypiCMS\Modules\Contacts\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Format creation date
     * @return String
     */
    public function createdAt()
    {
        return $this->entity->created_at->format('d.m.Y');
    }

    /**
     * Concatenate title, first_name and last_name
     * @return String
     */
    public function title()
    {
        return $this->entity->title . ' ' . $this->entity->first_name . ' ' . $this->entity->last_name;
    }
}
