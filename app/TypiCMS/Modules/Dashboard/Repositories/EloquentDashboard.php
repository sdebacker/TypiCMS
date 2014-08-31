<?php
namespace TypiCMS\Modules\Dashboard\Repositories;

use Config;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentDashboard extends RepositoriesAbstract implements DashboardInterface
{

    public function getWelcomeMessage()
    {
        if ($welcomeMessageURL = Config::get('typicms.welcomeMessageURL')) {
            $ch = curl_init($welcomeMessageURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $welcomeMessage = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
                return '';
            }
            curl_close($ch);
        } else {
            $welcomeMessage = Config::get('typicms.welcomeMessage');
        }

        return $welcomeMessage;
    }
}
