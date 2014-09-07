<?php
namespace TypiCMS\Commands;

use Exception;
use Schema;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class Database extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'typicms:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Set database credentials in env.php";

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
     * @return void
     */
    public function fire()
    {
        $contents = $this->getKeyFile();

        $dbName = $this->argument('database');
        $dbUserName = $this->ask('What is your MySQL username?');
        $dbPassword = $this->secret('What is your MySQL password?');

        // Replace DB credentials taken from env.php file
        $keys = ['MYSQL_DATABASE', 'MYSQL_USERNAME', 'MYSQL_PASSWORD'];
        $search = [
            "'$keys[0]' => ''",
            "'$keys[1]' => ''",
            "'$keys[2]' => ''",
        ];
        $replace = [
            "'$keys[0]' => '$dbName'",
            "'$keys[1]' => '$dbUserName'",
            "'$keys[2]' => '$dbPassword'",
        ];
        $contents = str_replace($search, $replace, $contents, $count);

        if ($count != 3) {
            throw new Exception('Error while writing credentials to .env.php.');
        }

        // Set DB credentials to laravel config
        $this->laravel['config']['database.connections.mysql.database'] = $dbName;
        $this->laravel['config']['database.connections.mysql.username'] = $dbUserName;
        $this->laravel['config']['database.connections.mysql.password'] = $dbPassword;

        $this->error($this->laravel['config']['local.database.connections.mysql.database']);

        // Migrate DB
        if (! Schema::hasTable('migrations')) {
            $this->call('migrate');
            $this->call('db:seed');
        } else {
            $this->error('A migrations table was found in database ['.$dbName.'], no migrate and seed were done.');
        }

        // Write to .env.php
        $env = $this->laravel->environment();
        $newPath = $env == 'production' ? '.env.php' : '.env.'.$env.'.php' ;
        $this->files->put($newPath, $contents);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('database', InputArgument::REQUIRED, 'The database name'),
        );
    }

    /**
     * Get the key file and contents.
     *
     * @return string
     */
    protected function getKeyFile()
    {
        return $this->files->get('env.php');
    }
}
