<?php
namespace TypiCMS\Modules\Dashboard\Repositories;

interface DashboardInterface
{

    /**
     * Retrieve the CSM’s Welcome message
     *
     * @return string formatted as html
     */
    public function getWelcomeMessage();
}
