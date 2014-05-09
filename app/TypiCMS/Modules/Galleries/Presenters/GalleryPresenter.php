<?php
namespace TypiCMS\Modules\Galleries\Presenters;

use Route;

use TypiCMS\Presenters\Presenter;

class GalleryPresenter extends Presenter
{

    /**
    * Files in list
    *
    * @return string
    */
    public function countFiles()
    {
        $nbFiles = count($this->entity->files);
        $label = $nbFiles ? 'label-success' : 'label-default' ;
        $html[] = '<span class="label ' . $label . '">';
        $html[] = $nbFiles;
        $html[] = '</span>';

        return implode("\r\n", $html);
    }
}
