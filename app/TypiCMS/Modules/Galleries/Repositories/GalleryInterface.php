<?php
namespace TypiCMS\Modules\Galleries\Repositories;

interface GalleryInterface
{
    /**
     * Get all items name
     * 
     * @return array with names
     */
    public function getNames();

    /**
     * Find existing galleries or forget it if they don't exist
     *
     * @param  array $galleries  Array of strings, each representing a tag
     * @return array        Array or Arrayable collection of Tag objects
     */
    public function findOrForget(array $galleries);
}
