<?php
namespace TypiCMS\Modules\Contacts\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class ContactPresenter extends AbstractPresenter implements Presentable
{

    /**
     * Format creation date
     * 
     * @return String
     */
    public function createdAt()
    {
        return $this->object->created_at->format('d.m.Y');
    }

    /**
     * Public uri
     * 
     * @return String
     */
    public function publicUri($lang)
    {
        return '/' . $lang;
    }
}
