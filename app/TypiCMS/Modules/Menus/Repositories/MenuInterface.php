<?php
namespace TypiCMS\Modules\Menus\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface MenuInterface extends RepositoryInterface
{

    /**
     * Get all menus
     *
     * @return array with key = menu name and value = menu model
     */
    public function getAllMenus();

    /**
     * Build a menu
     *
     * @param  string $name       menu name
     * @return string             html code of a menu
     */
    public function build($name);

    /**
     * Get a menu
     *
     * @param  string $name       menu name
     * @return Collection         nested collection
     */
    public function getMenu($name);
}
