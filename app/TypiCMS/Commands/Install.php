<?php
namespace TypiCMS\Commands;

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
        $this->checkThatEnvTemplateExists();

        $this->line('Welcome to TypiCMS');

        // Ask for database name
        $dbName = $this->ask('What is your database name? ');

        // Set database credentials in env.local.php and migrate
        $this->call('typicms:database', array('database' => $dbName));

        // Set cache key prefix
        $this->call('cache:prefix', array('prefix' => $dbName));

        // Composer install
        if (function_exists('system')) {
            system('npm install');
            $this->info('npm packages installed');
            system('bower install');
            $this->info('Bower packages installed');
            system('chmod -R 777 app/storage');
            $this->info('app/storage is now writable');
            system('chmod -R 777 public/uploads');
            $this->info('public/uploads is now writable');
        } else {
            $this->line('You can now make app/storage and public/uploads writable');
            $this->line('and run composer install, npm install and bower install.');
        }

        // publish debugbar
        $this->call('debugbar:publish');

        // Done
        $this->line('Done. Enjoy TypiCMS!');

    }

    /**
     * Check that env.php exists
     *
     * @return void      exit if env.php is not found
     */
    public function checkThatEnvTemplateExists()
    {
        if (! $this->files->exists('env.php')) {
            $this->error('No env.php template found.');
            exit();
        }
    }
}
