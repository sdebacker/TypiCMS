<?php namespace Basset\Console;

use RuntimeException;
use Basset\Collection;
use Basset\Environment;
use Basset\Builder\Builder;
use Illuminate\Console\Command;
use Basset\Builder\FilesystemCleaner;
use Basset\Exceptions\BuildNotRequiredException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BuildCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'basset:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build asset collections';

    /**
     * Basset environment instance.
     *
     * @var \Basset\Environment
     */
    protected $environment;

    /**
     * Basset builder instance.
     *
     * @var \Basset\Builder\Builder
     */
    protected $builder;

    /**
     * Basset filesystem cleaner instance.
     * 
     * @var \Basset\Builder\FilesystemCleaner
     */
    protected $cleaner;

    /**
     * Create a new basset compile command instance.
     *
     * @param  \Basset\Environment  $environment
     * @param  \Basset\Builder\Builder  $builder
     * @param  \Basset\Builder\FilesystemCleaner  $cleaner
     * @return void
     */
    public function __construct(Environment $environment, Builder $builder, FilesystemCleaner $cleaner)
    {
        parent::__construct();

        $this->environment = $environment;
        $this->builder = $builder;
        $this->cleaner = $cleaner;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->input->getOption('force') and $this->builder->setForce(true);

        $this->input->getOption('gzip') and $this->builder->setGzip(true);

        if ($production = $this->input->getOption('production'))
        {
            $this->comment('Starting production build...');
        }
        else
        {
            $this->comment('Starting development build...');
        }

        $collections = $this->gatherCollections();

        if ($this->input->getOption('gzip') and ! function_exists('gzencode'))
        {
            $this->error('[gzip] Build will not use Gzip as the required dependencies are not available.');
            $this->line('');
        }

        foreach ($collections as $name => $collection)
        {
            if ($production)
            {
                $this->buildAsProduction($name, $collection);
            }
            else
            {
                $this->buildAsDevelopment($name, $collection);
            }

            $this->cleaner->clean($name);
        }
    }

    /**
     * Dynamically handle calls to the build methods.
     * 
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, array('buildAsDevelopment', 'buildAsProduction')))
        {
            list($name, $collection) = $parameters;

            try
            {
                $this->builder->{$method}($collection, 'stylesheets');

                $this->line('<info>['.$name.']</info> Stylesheets successfully built.');
            }
            catch (BuildNotRequiredException $error)
            {
                $this->line('<comment>['.$name.']</comment> Stylesheets build was not required for collection.');
            }

            try
            {
                $this->builder->{$method}($collection, 'javascripts');

                $this->line('<info>['.$name.']</info> Javascripts successfully built.');
            }
            catch (BuildNotRequiredException $error)
            {
                $this->line('<comment>['.$name.']</comment> Javascripts build was not required for collection.');
            }

            $this->line('');
        }
        else
        {
            return parent::__call($method, $parameters);
        }
    }

    /**
     * Gather the collections to be built.
     *
     * @return array
     */
    protected function gatherCollections()
    {
        if ( ! is_null($collection = $this->input->getArgument('collection')))
        {
            if ( ! $this->environment->has($collection))
            {
                $this->comment('['.$collection.'] Collection not found.');

                return array();
            }

            $this->comment('Gathering assets for collection...');

            $collections = array($collection => $this->environment->collection($collection));
        }
        else
        {
            $this->comment('Gathering all collections to build...');

            $collections = $this->environment->all();
        }

        $this->line('');

        return $collections;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('collection', InputArgument::OPTIONAL, 'The asset collection to build'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('production', 'p', InputOption::VALUE_NONE, 'Build assets for a production environment'),
            array('gzip', null, InputOption::VALUE_NONE, 'Gzip built assets'),
            array('force', 'f', InputOption::VALUE_NONE, 'Forces a re-build of the collection')
        );
    }

}