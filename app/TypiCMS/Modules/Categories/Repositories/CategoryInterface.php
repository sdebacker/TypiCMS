<?php
namespace TypiCMS\Modules\Categories\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface CategoryInterface extends RepositoryInterface
{

    /**
     * Get all categories for select/option
     *
     * @return array
     */
    public function getAllForSelect();

    /**
     * Get all categories and prepare for menu
     *
     * @param  string $uri
     * @return array
     */
    public function getAllForMenu($uri = '');
}
