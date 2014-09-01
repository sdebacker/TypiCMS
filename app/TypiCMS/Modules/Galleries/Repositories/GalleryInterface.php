<?php
namespace TypiCMS\Modules\Galleries\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface GalleryInterface extends RepositoryInterface
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
