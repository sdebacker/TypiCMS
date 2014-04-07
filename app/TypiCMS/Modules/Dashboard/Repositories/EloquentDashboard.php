<?php
namespace TypiCMS\Modules\Dashboard\Repositories;

use DB;
use Str;
use Config;
use Sentry;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentDashboard extends RepositoriesAbstract implements DashboardInterface
{

    public function getWelcomeMessage()
    {
        if ($welcomeMessageURL = Config::get('typicms.welcomeMessageURL')) {
            $ch = curl_init($welcomeMessageURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
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

    public function getModulesList()
    {

        // Item not cached, retrieve it
        $modulesArray = Config::get('app.modules');
        $modulesForDashboard = array();
        foreach ($modulesArray as $module => $property) {
            $lowerName = strtolower($module);
            if ($property['dashboard'] and Sentry::getUser()->hasAccess('admin.' . $lowerName . '.index')) {
                $modulesForDashboard[$module]['name'] = $module;
                $modulesForDashboard[$module]['route'] = $lowerName;
                $modulesForDashboard[$module]['title'] = Str::title(trans($lowerName . '::global.name'));
                $modulesForDashboard[$module]['count'] = DB::table($lowerName)->count();
            }
        }

        return $modulesForDashboard;
    }

}
