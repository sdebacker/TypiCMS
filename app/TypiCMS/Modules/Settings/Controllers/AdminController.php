<?php
namespace TypiCMS\Modules\Settings\Controllers;

use BigName\BackupManager\Manager;
use Cache;
use Config;
use Exception;
use Input;
use Log;
use Notification;
use Redirect;
use Response;
use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Settings\Repositories\SettingInterface;
use View;

class AdminController extends AdminSimpleController
{

    protected $manager;

    public function __construct(SettingInterface $setting, Manager $manager)
    {
        $this->manager = $manager;
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
     * @return Redirect
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
     * @return Response|Redirect
     */
    public function backup()
    {
        try {
            $databaseType = Config::get('database.default');
            $databaseName = Config::get('database.connections.' . $databaseType . '.database');
            $fileDir      = Config::get('backup-manager::storage.local.root');
            $fileName     = $databaseName . '-' . date('Y-m-d_H:i:s') . '.sql';
            $pathToFile   = $fileDir . '/' . $fileName . '.gz';
            $this->manager->makeBackup()->run($databaseType, 'local', $fileName, 'gzip');
            return Response::download($pathToFile);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            Notification::error(trans('settings::global.Unable to backup database') . '.');
        }
        return Redirect::route('admin.settings.index');
    }
}
