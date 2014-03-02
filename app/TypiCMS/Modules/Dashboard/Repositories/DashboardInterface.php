<?php namespace TypiCMS\Modules\Dashboard\Repositories;

interface DashboardInterface
{

    /**
     * Retrieve the CSM’s Welcome message
     *
     * @return string formatted as html
     */
    public function getWelcomeMessage();

    /**
     * Retrieve list of modules from config
     *
     * @return array
     */
    public function getModulesList();

}