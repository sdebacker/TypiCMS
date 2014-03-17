<?php namespace TypiCMS\Modules\Menus\Repositories;

interface MenuInterface
{

    /**
     * Get all models
     *
     * @param boolean $all Show published or all
     * @param array $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false);

}
