<?php
namespace TypiCMS\Modules\Files\Presenters;

use Croppa;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Create thumb
     * @param  string $size    xs, sm, md, lg
     * @param  array  $options PHPThumb style option
     * @return string          html img tag or div with doc icon
     */
    public function thumb($width = 130, $height = 130, array $options = array(), $field = 'filename')
    {
        if ($this->isImage($this->entity)) {
            $src = Croppa::url(
                '/'.$this->entity->path.'/'.$this->entity->filename,
                $width,
                $height,
                $options
            );
            return '<img src="' . $src . '" alt="' . $this->entity->alt_attribute . '">';
        } else {
            return '<div class="text-center doc"><i class="text-center fa fa-file-text-o"></i></div>';
        }
    }

    /**
     * Check if file is an image
     * @param  Object  $object file object
     * @return boolean
     */
    private function isImage($object)
    {
        return in_array(strtolower($object->extension), array('.jpg', '.jpeg', '.gif', '.png'));
    }
}
