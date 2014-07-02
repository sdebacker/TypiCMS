<?php
namespace TypiCMS\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class Database extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cms:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Set database credentials in env.local.php";

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
        list($path, $contents) = $this->getKeyFile();

        $dbName = $this->argument('database');
        $dbUserName = $this->ask('What is your MySQL username?');
        $dbPassword = $this->secret('What is your MySQL password?');

        // Replace DB credentials taken from env.local.php file
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
            $this->error("Error on writing credentials to env.local.php.");
            exit();
        }

        // Set DB credentials to laravel config
        $this->laravel['config']['database.connections.mysql.database'] = $dbName;
        $this->laravel['config']['database.connections.mysql.username'] = $dbUserName;
        $this->laravel['config']['database.connections.mysql.password'] = $dbPassword;

        // Migrate DB
        $this->call('migrate', array('--seed'));

        // If migration succeeds, write credentials to env.local.php
        $this->files->put($path, $contents);

        // Move env.local.php to .env.local.php
        if ($this->laravel->environment('local')) {
            $this->files->move($path, '.env.local.php');
        } else {
            $this->files->move($path, '.env.php');
        }
        

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
     * @return array
     */
    protected function getKeyFile()
    {
        $contents = $this->files->get($path = "env.local.php");
        return array($path, $contents);
    }

}
