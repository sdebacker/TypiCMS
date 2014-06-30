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
     * Delete model and attached files
     *
     * @return boolean
     */
    public function delete($model);
}
