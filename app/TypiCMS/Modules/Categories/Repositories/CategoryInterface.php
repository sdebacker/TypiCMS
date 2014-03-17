<?php
namespace TypiCMS\Modules\Categories\Repositories;

interface CategoryInterface
{

    /**
     * Get all categories
     *
     * @return array
     */
    public function getAllForSelect();


}