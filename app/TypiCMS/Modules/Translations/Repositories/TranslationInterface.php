<?php
namespace TypiCMS\Modules\Translations\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface TranslationInterface extends RepositoryInterface
{

    /**
     * Get translations to Array
     *
     * @return array
     */
    public function getAllToArray($locale, $group, $namespace = null);
}
