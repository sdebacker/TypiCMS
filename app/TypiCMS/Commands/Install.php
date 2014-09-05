<?php
namespace TypiCMS\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class Install extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'typicms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installation of TypiCMS: initial Laravel setup, composer, bower, npm';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new key generator command.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $defaultEnvironmentFile = 'bootstrap/environment.local.php';
        $environmentFile = 'bootstrap/environment.php';

        $this->line('Welcome to TypiCMS');

        if (! $this->files->exists($environmentFile) && $this->files->exists($defaultEnvironmentFile)) {
            // move default environment file so current environment will be local.
            $this->files->move($defaultEnvironmentFile, $environmentFile);
            // set environment to local
            $this->laravel['env'] = 'local';
            $this->line('----------------------');
            $this->info('Environment set to local');
            $this->line('----------------------');
        }

        $this->checkThatEnvTemplateExists();

        // Ask for database name
        $dbName = $this->ask('What is your database name? ');

        // Set database credentials in env.local.php and migrate
        $this->call('typicms:database', array('database' => $dbName));
        $this->line('----------------------');

        // Set cache key prefix
        $this->call('cache:prefix', array('prefix' => $dbName));
        $this->line('----------------------');

        // Composer install
        if (function_exists('system')) {
            $this->info('Running npm install...');
            system('npm install');
            $this->info('npm packages installed');
            $this->line('----------------------');
            $this->info('Running bower install...');
            system('bower install');
            $this->info('Bower packages installed');
            $this->line('----------------------');
            system('chmod -R 777 app/storage');
            $this->info('app/storage is now writable');
            system('chmod -R 777 public/uploads');
            $this->info('public/uploads is now writable');
        } else {
            $this->line('You can now make app/storage and public/uploads writable');
            $this->line('and run composer install, npm install and bower install.');
        }

        // Done
        $this->line('----------------------');
        $this->line('Done. Enjoy TypiCMS!');

    }

    /**
     * Check that env.php exists
     *
     * @return void      Exception if env.php is not found
     */
    public function checkThatEnvTemplateExists()
    {
        if (! $this->files->exists('env.php')) {
            throw new Exception('No env.php template found.');
        }
    }
}
