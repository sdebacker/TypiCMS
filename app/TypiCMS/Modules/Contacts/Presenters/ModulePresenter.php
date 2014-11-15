<?php
namespace TypiCMS\Modules\Contacts\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Format creation date
     * @return string
     */
    public function createdAt()
    {
        return $this->entity->created_at->format('d.m.Y');
    }

    /**
     * Get title by concatenate title, first_name and last_name
     * 
     * @return string
     */
    public function title()
    {
        return $this->entity->title . ' ' . $this->entity->first_name . ' ' . $this->entity->last_name;
    }
}
