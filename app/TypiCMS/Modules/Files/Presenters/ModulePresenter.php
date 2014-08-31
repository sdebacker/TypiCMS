<?php
namespace TypiCMS\Modules\Files\Presenters;

use Croppa;
use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Create thumb
     * @param  array  $options PHPThumb style option
     * @return string          html img tag or div with doc icon
     */
    public function thumb($width = 130, $height = 130, array $options = array(), $field = 'filename')
    {
        if ($this->entity->type == 'i') {
            $src = Croppa::url(
                '/'.$this->entity->path.'/'.$this->entity->filename,
                $width,
                $height,
                $options
            );
            return '<img class="img-responsive" src="' . $src . '" alt="' . $this->entity->alt_attribute . '">';
        } else {
            return '<div class="text-center doc"><i class="text-center fa fa-file-text-o"></i></div>';
        }
    }

    /**
     * Return an icon and file name
     *
     * @param  int $size       size of the icon
     * @param  string $field   field name
     * @return string          HTML markup of an image
     */
    public function icon($size = 1, $field = 'document')
    {
        $file = '/' . $this->entity->path . $this->entity->$field;
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
}
