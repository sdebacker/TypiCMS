<?php namespace TypiCMS\Repositories\Dashboard;

use DB;
use Str;
use Sentry;
use Config;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentDashboard extends RepositoriesAbstract implements DashboardInterface {


	public function getWelcomeMessage()
	{
		d('Getting welcome message');
		$ch = curl_init('http://www.typi.be/welcomeMessage_fr.html');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$welcomeMessage = curl_exec($ch);
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
			return '';
		}
		curl_close($ch);
		return $welcomeMessage;
	}


	public function getDashboardModules()
	{

		d('Building Dashboard Modules');
		// Item not cached, retrieve it
		$modulesArray = Config::get('app.modules');
		$modulesForDashboard = array();
		foreach ($modulesArray as $module => $property) {
			$lowerName = strtolower($module);
			if ($property['dashboard'] and Sentry::getUser()->hasAccess('admin.' . $lowerName . '.index')) {
				$modulesForDashboard[$module]['name'] = $module;
				$modulesForDashboard[$module]['route'] = $lowerName;
				$modulesForDashboard[$module]['title'] = Str::title(trans_choice('modules.'.$lowerName.'.'.$lowerName, 2));
				$modulesForDashboard[$module]['count'] = DB::table($lowerName)->count();
			}
		}

		return $modulesForDashboard;
	}

}