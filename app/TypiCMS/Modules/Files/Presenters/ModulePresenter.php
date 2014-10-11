<?php
namespace TypiCMS\Modules\Files\Presenters;

use Croppa;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Get the path of files linked to this model
     * 
     * @param  Model  $model
     * @param  string $field file’s field name in model
     * @return string path
     */
    protected function getPath(Model $model = null, $field = null)
    {
        if (! $model || ! $field) {
            return null;
        }
        return '/' . $model->path . '/' . $model->$field;
    }

    /**
     * Return an icon and file name
     *
     * @param  int    $size    icon size
     * @param  string $field   field name
     * @return string          HTML code
     */
    public function icon($size = 1, $field = 'document')
    {
        $file = $this->getPath($this->entity, $field);
        $html = '<div class="doc">';
        $html .= '<span class="text-center fa fa-file-o fa-' . $size . 'x"></span>';
        $html .= ' <a href="' . $file . '">';
        $html .= $this->entity->$field;
        $html .= '</a>';
        if (! is_file(public_path() . $file)) {
            $html .= ' <span class="text-danger">(' . trans('global.Not found') . ')</span>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Return filename
     * @return String
     */
    public function title()
    {
        return $this->entity->filename;
    }
}
