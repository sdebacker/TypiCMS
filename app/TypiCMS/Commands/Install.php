<?php
namespace TypiCMS\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use TypiCMS\Modules\Users\Repositories\SentryUser;

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
     * @var Filesystem
     */
    protected $files;

    /**
     * The user repository.
     *
     * @var SentryUser
     */
    protected $user;

    /**
     * Create a new key generator command.
     *
     * @param  SentryUser  $user
     * @param  Filesystem  $files
     * @return void
     */
    public function __construct(SentryUser $user, Filesystem $files)
    {
        parent::__construct();

        $this->user = $user;
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        $this->line('Welcome to TypiCMS');

        $this->laravel['env'] = 'local';

        $this->checkThatEnvTemplateExists();

        // Ask for database name
        $this->info('Setting up database...');
        $dbName = $this->ask('What is your database name? ');

        // Set database credentials in env.local.php and migrate
        $this->call('typicms:database', array('database' => $dbName));
        $this->line('----------------------');

        // Create a super user
        $this->createSuperUser();

        // Set cache key prefix
        $this->call('cache:prefix', array('prefix' => $dbName));
        $this->line('----------------------');

        // Composer install
        if (function_exists('system')) {
            $this->info('Running npm install...');
            system('npm install');
            $this->info('npm packages installed.');
            $this->line('----------------------');
            $this->info('Running bower install...');
            system('bower install');
            $this->info('Bower packages installed.');
            $this->line('----------------------');
            system('chmod -R 777 app/storage');
            $this->info('app/storage is now writable.');
            system('chmod -R 777 public/uploads');
            $this->info('public/uploads is now writable.');
        } else {
            $this->line('You can now make app/storage and public/uploads writable');
            $this->line('and run composer install, npm install and bower install.');
        }

        // Done
        $this->line('----------------------');
        $this->line('Done. Enjoy TypiCMS!');

    }

    /**
     * Check that .env.example exists
     *
     * @return void|Exception when .env.example is not found
     */
    public function checkThatEnvTemplateExists()
    {
        if (! $this->files->exists('.env.example')) {
            throw new Exception('No .env.example file found.');
        }
    }

    /**
     * Create a superuser
     */
    private function createSuperUser()
    {
        $this->info('Creating a Super User...');

        $firstname = $this->ask('Enter your first name   ');
        $lastname  = $this->ask('Enter your last name    ');
        $email     = $this->ask('Enter your email address');
        $password  = $this->secret('Enter a password        ');

        $user = [
            'first_name'  => $firstname,
            'last_name'   => $lastname,
            'email'       => $email,
            'permissions' => ['superuser' => 1],
            'groups'      => [1 => 1],
            'activated'   => 1,
            'password'    => $password,
        ];
        $user = $this->user->create($user);

        if ($user) {
            $this->info('Superuser created.');
        } else {
            $this->error('User could not be created.');
        }
        $this->line('----------------------');
    }
}
