<?php
namespace TypiCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class CacheKeyPrefix extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cache:prefix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Set the application cache key prefix";

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
        list($path, $contents) = $this->getKeyFile();

        $prefix = $this->argument('prefix');

        $contents = str_replace($this->laravel['config']['cache.prefix'], $prefix, $contents);

        $this->files->put($path, $contents);

        $this->laravel['config']['cache.prefix'] = $prefix;

        $this->info("Application cache key prefix [$prefix] set successfully.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('prefix', InputArgument::REQUIRED, 'The cache key prefix'),
        );
    }

    /**
     * Get the key file and contents.
     *
     * @return string[]
     */
    protected function getKeyFile()
    {
        $contents = $this->files->get($path = $this->laravel['path']."/config/cache.php");

        return array($path, $contents);
    }
}
