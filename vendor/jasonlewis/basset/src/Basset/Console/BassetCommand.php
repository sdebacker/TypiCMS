<?php namespace Basset\Console;

use Basset\Environment;
use Basset\Manifest\Manifest;
use Illuminate\Console\Command;
use Basset\Builder\FilesystemCleaner;
use Basset\BassetServiceProvider as Basset;
use Symfony\Component\Console\Input\InputOption;

class BassetCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'basset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interact with the Basset package';

    /**
     * Basset manifest instance.
     * 
     * @var \Basset\Manifest\Manifest
     */
    protected $manifest;

    /**
     * Basset environment instance.
     * 
     * @var \Basset\Environment
     */
    protected $environment;

    /**
     * Basset filesystem cleaner instance.
     * 
     * @var \Basset\Builder\FilesystemCleaner
     */
    protected $cleaner;

    /**
     * Path to the manifest storage.
     * 
     * @var string
     */
    protected $manifestPath;

    /**
     * Create a new basset command instance.
     * 
     * @param  \Basset\Manifest\Manifest  $manifest
     * @param  \Basset\Environment  $environment
     * @param  \Basset\Builder\FilesystemCleaner  $cleaner
     * @return void
     */
    public function __construct(Manifest $manifest, Environment $environment, FilesystemCleaner $cleaner)
    {
        parent::__construct();

        $this->manifest = $manifest;
        $this->environment = $environment;
        $this->cleaner = $cleaner;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if ( ! $this->input->getOption('delete-manifest') and ! $this->input->getOption('tidy-up'))
        {
            $this->line('<info>Basset</info> version <comment>'.Basset::VERSION.'</comment>');
        }
        else
        {
            if ($this->input->getOption('delete-manifest'))
            {
                $this->deleteCollectionManifest();
            }

            if ($this->input->getOption('tidy-up'))
            {
                $this->tidyUpFilesystem();
            }
        }
    }

    /**
     * Delete the collection manifest.
     * 
     * @return void
     */
    protected function deleteCollectionManifest()
    {
        if ($this->manifest->delete())
        {
            $this->info('Manifest has been deleted. All collections will are now required to be rebuilt.');
        }
        else
        {
            $this->comment('Manifest does not exist or could not be deleted.');
        }
    }

    /**
     * Tidy up the filesystem with the build cleaner.
     * 
     * @return void
     */
    protected function tidyUpFilesystem()
    {
        $collections = array_keys($this->environment->all()) + array_keys($this->manifest->all());

        foreach ($collections as $collection)
        {
            if ($this->input->getOption('verbose'))
            {
                $this->line('['.$collection.'] Cleaning up files and manifest entries.');
            }

            $this->cleaner->clean($collection);
        }

        $this->input->getOption('verbose') and $this->line('');

        $this->info('The filesystem and manifest have been tidied up.');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('delete-manifest', null, InputOption::VALUE_NONE, 'Delete the collection manifest'),
            array('tidy-up', null, InputOption::VALUE_NONE, 'Tidy up the outdated collections and manifest entries')
        );
    }

}