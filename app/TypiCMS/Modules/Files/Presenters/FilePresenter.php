<?php
namespace TypiCMS\Modules\Files\Presenters;

use Croppa;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class FilePresenter extends AbstractPresenter implements Presentable
{

    public function thumb()
    {
        if ($this->isImage($this->object)) {
            return '<img src="' . Croppa::url('/'.$this->object->path.'/'.$this->object->filename, 130, 130, array('quadrant' => 'T')) . '" alt="' . $this->object->alt_attribute . '">';
        } else {
            return '<div class="text-center doc"><i class="text-center fa fa-file-text-o"></i></div>';
        }
    }

    public function isImage($object)
    {
        return in_array(strtolower($object->extension), array('.jpg', '.jpeg', '.gif', '.png'));
    }
}
