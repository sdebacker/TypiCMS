<?php
namespace TypiCMS\Modules\Contacts\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class ContactPresenter extends AbstractPresenter implements Presentable
{

    /**
     * Concat first_name aned last_name
     * 
     * @return String
     */
    public function full_name()
    {
        return $this->object->first_name . ' ' . $this->object->last_name;
    }

    /**
     * Format creation date
     * 
     * @return String
     */
    public function created_at()
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
