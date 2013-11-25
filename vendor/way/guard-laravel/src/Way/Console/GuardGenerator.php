<?php namespace Way\Console;

use Illuminate\Filesystem\Filesystem;

class GuardGenerator {

    /**
     * Filesystem
     * @var Illuminate\Filesystem
     */
    protected $file;

    /**
     * GuardFile
     *
     * @var Way\Console\Guardfile
     */
    protected $guardFile;

    /**
     * Create a new controller generator instance.
     *
     * @param  Illuminate\Filesystem  $file
     * @return void
     */
    public function __construct(Filesystem $file, Guardfile $guardFile)
    {
        $this->file = $file;
        $this->guardFile = $guardFile;
    }

    /**
     * Generate an asset folder
     *
     * @param  string $dir
     * @return void
     */
    public function folder($dir)
    {
        if (! $this->file->exists($dir))
        {
            $this->file->makeDirectory($dir, 0777, true);
        }
    }

    /**
     * Generate the Guardfile and boilerplate
     *
     * @param  array  $plugins List of desired plugins
     * @return void
     */
    public function guardFile(array $plugins)
    {
        // Sort Guardfile plugins alphabetically
        sort($plugins);

        $stubs = $this->guardFile->getStubs($plugins);
        $this->guardFile->put($stubs);
    }

    /**
     * Save a list of requested plugins for future use
     *s
     * @param  array $plugins
     * @param string $logPath
     * @return void
     */
    public function log(array $plugins, $logPath = null)
    {
        $logPath = $logPath ?: app_path().'/storage/guard';
        $this->folder($logPath);

        // We'll store a space separated list of all requested plugins.
        $this->file->put($logPath .'/plugins.txt', json_encode($plugins));
    }

}