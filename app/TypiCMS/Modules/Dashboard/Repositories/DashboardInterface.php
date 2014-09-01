<?php
namespace TypiCMS\Modules\Dashboard\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface DashboardInterface extends RepositoryInterface
{

    /**
     * Retrieve the CSM’s Welcome message
     *
     * @return string formatted as html
     */
    public function getWelcomeMessage();
}
