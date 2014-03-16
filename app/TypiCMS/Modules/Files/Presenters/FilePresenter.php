<?php namespace TypiCMS\Modules\Files\Presenters;

use Croppa;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class FilePresenter extends AbstractPresenter implements Presentable
{

    public function thumb()
    {
        return '<img src="' . Croppa::url('/'.$this->object->path.'/'.$this->object->filename, 130, 130, array('quadrant' => 'T')) . '" alt="' . $this->object->alt_attribute . '">';
    }
}
