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
    public function thumb($size = 'sm', $options = array('quadrant' => 'T'))
    {
        $sizes = ['xs' => 24, 'sm' => 130, 'md' => 200, 'lg' => 400];

        if ($this->isImage($this->entity)) {
            $src = Croppa::url(
                '/'.$this->entity->path.'/'.$this->entity->filename,
                $sizes[$size],
                $sizes[$size],
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
