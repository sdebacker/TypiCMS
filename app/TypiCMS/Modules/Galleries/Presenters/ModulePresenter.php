<?php
namespace TypiCMS\Modules\Galleries\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
    * Files in list
    *
    * @return string
    */
    public function countFiles()
    {
        $nbFiles = $this->entity->files->count();
        $label = $nbFiles ? 'label-success' : 'label-default' ;
        $html = array();
        $html[] = '<span class="label ' . $label . '">';
        $html[] = $nbFiles;
        $html[] = '</span>';

        return implode("\r\n", $html);
    }
}
