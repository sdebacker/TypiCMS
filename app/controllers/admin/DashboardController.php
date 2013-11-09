<?php namespace App\Controllers\Admin;
 
use View;
use Config;
use Response;
use App;

use TypiCMS\Models\Menu;
use TypiCMS\Repositories\Dashboard\DashboardInterface;

use McCool\DatabaseBackup\Processors\ShellProcessor;
use McCool\DatabaseBackup\Dumpers\MysqlDumper;
use McCool\DatabaseBackup\Archivers\GzipArchiver;
use McCool\DatabaseBackup\Storers\S3Storer;
use McCool\DatabaseBackup\BackupProcedure;

use Symfony\Component\Process\Process;

class DashboardController extends BaseController {

	public function __construct(DashboardInterface $dashboard)
	{
		parent::__construct($dashboard);
		$this->title['parent'] = trans('global.Dashboard');
	}

	public function index($relid = null)
	{
		$menus = Menu::orderBy('id')->translations()->get();

		$this->title['child'] = trans('global.Dashboard');

		$modules = $this->repository->getDashboardModules();
		
		$this->layout->content = View::make('admin.dashboard')
			->with('welcomeMessage', $this->getWelcomeMessage())
			->with('modules', $modules)
			->with('menus', $menus);
	}

	public function backup()
	{
		// DB info
		$host = Config::get('database.connections.mysql.host');
		$username = Config::get('database.connections.mysql.username');
		$password = Config::get('database.connections.mysql.password');
		$database = Config::get('database.connections.mysql.database');

		// SQL file
		$file = storage_path().'/backup/'.$database.'-'.date('c').'.sql';

		// Export
		$shellProcessor = new ShellProcessor(new Process(''));
		$dumper = new MysqlDumper($shellProcessor, $host, 3306, $username, $password, $database, $file);
		$backup = new BackupProcedure($dumper);
		$backup->backup();

		// DL File
		return Response::download($file);
	}

	public function getWelcomeMessage()
	{
		$ch = curl_init('http://www.typi.be/welcomeMessage_fr.html');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$welcomeMessage = curl_exec($ch);
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
			return '';
		}
		curl_close($ch);
		return $welcomeMessage;
	}

}