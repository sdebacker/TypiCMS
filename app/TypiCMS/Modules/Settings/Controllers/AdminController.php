<?php
namespace TypiCMS\Modules\Settings\Controllers;

use View;
use Cache;
use Input;
use Config;
use Response;
use Redirect;
use Notification;
use Symfony\Component\Process\Process;
use McCool\DatabaseBackup\BackupProcedure;
use McCool\DatabaseBackup\Dumpers\MysqlDumper;
use McCool\DatabaseBackup\Processors\ShellProcessor;
use TypiCMS\Modules\Settings\Repositories\SettingInterface;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(SettingInterface $setting)
    {
        parent::__construct($setting);
        $this->title['parent'] = ucfirst(trans('global.settings'));
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $data = $this->repository->getAll(array(), true);
        $this->layout->content = View::make('settings.admin.index')
            ->withData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();

        // add checkboxes data
        $data['langChooser'] = Input::get('langChooser', 0);
        $data['authPublic']  = Input::get('authPublic', 0);
        $data['register']    = Input::get('register', 0);
        foreach (Config::get('app.locales') as $locale) {
            $data[$locale]['status'] = Input::get($locale.'.status', 0);
        }

        $this->repository->store($data);

        return Redirect::route('admin.settings.index');

    }

    /**
     * Clear app cache
     *
     * @return redirect
     */
    public function clearCache()
    {
        Cache::flush();
        Notification::success(trans('settings::global.Cache cleared') . '.');
        return Redirect::route('admin.settings.index');
    }

    /**
     * Backup DB
     *
     * @return File download
     */
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
