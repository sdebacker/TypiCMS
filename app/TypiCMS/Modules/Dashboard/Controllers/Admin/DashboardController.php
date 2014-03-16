<?php namespace TypiCMS\Modules\Dashboard\Controllers\Admin;

use View;
use Config;
use Response;

use Symfony\Component\Process\Process;

use McCool\DatabaseBackup\BackupProcedure;
use McCool\DatabaseBackup\Storers\S3Storer;
use McCool\DatabaseBackup\Dumpers\MysqlDumper;
use McCool\DatabaseBackup\Archivers\GzipArchiver;
use McCool\DatabaseBackup\Processors\ShellProcessor;

use TypiCMS\Modules\Menus\Models\Menu;
use TypiCMS\Modules\Dashboard\Repositories\DashboardInterface;

use TypiCMS\Controllers\BaseController;

class DashboardController extends BaseController {

    public function __construct(DashboardInterface $dashboard)
    {
        parent::__construct($dashboard);
        $this->title['parent'] = trans('dashboard::global.Dashboard');
    }

    public function index($relid = null)
    {
        $menus = Menu::with('translations')->get();

        $this->title['child'] = trans('dashboard::global.Dashboard');

        $modules = $this->repository->getModulesList();
        
        $this->layout->content = View::make('dashboard.admin.dashboard')
            ->with('welcomeMessage', $this->repository->getWelcomeMessage())
            ->withModules($modules)
            ->withMenus($menus);
    }

    public function backup()
    {
        // DB info
        $host = Config::get('database.connections.mysql.host');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $database = Config::get('database.connections.mysql.database');

        // SQL file
        $file = storage_path().'/backup/'.$database.'.sql';

        // Export
        $shellProcessor = new ShellProcessor(new Process(''));
        $dumper = new MysqlDumper($shellProcessor, $host, 3306, $username, $password, $database, $file);
        $backup = new BackupProcedure($dumper);
        $backup->backup();

        // DL File
        return Response::download($file);
    }

}