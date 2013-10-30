<?php namespace Basset;

use Closure;
use Iterator;
use Exception;
use FilesystemIterator;
use Basset\Filter\Filterable;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Basset\Factory\FactoryManager;
use Basset\Exceptions\AssetNotFoundException;
use Basset\Exceptions\DirectoryNotFoundException;

class Directory extends Filterable {

    /**
     * Directory path.
     *
     * @var string
     */
    protected $path;

    /**
     * Basset factory manager instance.
     *
     * @var \Basset\Factory\FactoryManager
     */
    protected $factory;

    /**
     * Basset asset finder instance.
     *
     * @var \Basset\AssetFinder
     */
    protected $finder;

    /**
     * Collection of assets added to the directory.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $assets;

    /**
     * Collection of nested directories.
     * 
     * @var \Illuminate\Support\Collection
     */
    protected $directories;

    /**
     * Create a new directory instance.
     *
     * @param  \Basset\Factory\FactoryManager  $factory
     * @param  \Basset\AssetFinder  $finder
     * @param  string  $path
     * @return void
     */
    public function __construct(FactoryManager $factory, AssetFinder $finder, $path)
    {
        parent::__construct();
        
        $this->factory = $factory;
        $this->finder = $finder;
        $this->path = $path;
        $this->assets = new \Illuminate\Support\Collection;
        $this->directories = new \Illuminate\Support\Collection;
    }

    /**
     * Find and add an asset to the directory.
     *
     * @param  string  $name
     * @param  \Closure  $callback
     * @return \Basset\Asset
     */
    public function add($name, Closure $callback = null)
    {
        try
        {
            $path = $this->finder->find($name);

            if (isset($this->assets[$path]))
            {
                $asset = $this->assets[$path];
            }
            else
            {
                $asset = $this->factory->get('asset')->make($path);

                $asset->isRemote() and $asset->raw();
            }

            is_callable($callback) and call_user_func($callback, $asset);

            return $this->assets[$path] = $asset;
        }
        catch (AssetNotFoundException $e)
        {
            $this->getLogger()->error(sprintf('Asset "%s" could not be found in "%s"', $name, $this->path));

            return $this->factory->get('asset')->make(null);
        }
    }

    /**
     * Find and add a javascript asset to the directory.
     * 
     * @param  string  $name
     * @param  \Closure  $callback
     * @return \Basset\Asset
     */
    public function javascript($name, Closure $callback = null)
    {
        return $this->add($name, function($asset) use ($callback)
        {
            $asset->setGroup('javascripts');

            is_callable($callback) and call_user_func($callback, $asset);
        });
    }

    /**
     * Find and add a stylesheet asset to the directory.
     * 
     * @param  string  $name
     * @param  \Closure  $callback
     * @return \Basset\Asset
     */
    public function stylesheet($name, Closure $callback = null)
    {
        return $this->add($name, function($asset) use ($callback)
        {
            $asset->setGroup('stylesheets');

            is_callable($callback) and call_user_func($callback, $asset);
        });
    }

    /**
     * Change the working directory.
     *
     * @param  string  $path
     * @param  \Closure  $callback
     * @return \Basset\Collection|\Basset\Directory
     */
    public function directory($path, Closure $callback = null)
    {
        try
        {
            $path = $this->finder->setWorkingDirectory($path);

            $this->directories[$path] = new Directory($this->factory, $this->finder, $path);

            // Once we've set the working directory we'll fire the callback so that any added assets
            // are relative to the working directory. After the callback we can revert the working
            // directory.
            is_callable($callback) and call_user_func($callback, $this->directories[$path]);

            $this->finder->resetWorkingDirectory();

            return $this->directories[$path];
        }
        catch (DirectoryNotFoundException $e)
        {
            $this->getLogger()->error(sprintf('Directory "%s" could not be found in "%s"', $path, $this->path));

            return new Directory($this->factory, $this->finder, null);
        }
    }

    /**
     * Recursively iterate through a given path.
     *
     * @param  string  $path
     * @return \RecursiveIteratorIterator
     */
    public function recursivelyIterateDirectory($path)
    {
        try
        {
            return new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        }
        catch (Exception $e) { return false; }
    }

    /**
     * Iterate through a given path.
     *
     * @param  string  $path
     * @return \FilesystemIterator
     */
    public function iterateDirectory($path)
    {
        try
        {
            return new FilesystemIterator($path);
        }
        catch (Exception $e) { return false; }
    }

    /**
     * Require a directory.
     *
     * @param  string  $path
     * @return \Basset\Directory
     */
    public function requireDirectory($path = null)
    {
        if ( ! is_null($path))
        {
            return $this->directory($path)->requireDirectory();
        }

        if ($iterator = $this->iterateDirectory($this->path))
        {
            return $this->processRequire($iterator);
        }

        return $this;
    }

    /**
     * Require a directory tree.
     *
     * @param  string  $path
     * @return \Basset\Directory
     */
    public function requireTree($path = null)
    {
        if ( ! is_null($path))
        {
            return $this->directory($path)->requireTree();
        }

        if ($iterator = $this->recursivelyIterateDirectory($this->path))
        {
            return $this->processRequire($iterator);
        }

        return $this;
    }

    /**
     * Process a require of either the directory or tree.
     * 
     * @param  \Iterator  $iterator
     * @return \Basset\Directory
     */
    protected function processRequire(Iterator $iterator)
    {
        // Spin through each of the files within the iterator and if their a valid asset they
        // are added to the array of assets for this directory.
        foreach ($iterator as $file)
        {
            if ( ! $file->isFile()) continue;

            $this->add($file->getPathname());
        }

        return $this;
    }

    /**
     * Exclude an array of assets.
     *
     * @param  string|array  $assets
     * @return \Basset\Directory
     */
    public function except($assets)
    {
        $assets = array_flatten(func_get_args());

        // Store the directory instance on a variable that we can inject into the scope of
        // the closure below. This allows us to call the path conversion method.
        $directory = $this;

        $this->assets = $this->assets->filter(function($asset) use ($assets, $directory)
        {
            $path = $directory->getPathRelativeToDirectory($asset->getRelativePath());

            return ! in_array($path, $assets);
        });

        return $this;
    }

    /**
     * Include only a subset of assets.
     *
     * @param  string|array  $assets
     * @return \Basset\Directory
     */
    public function only($assets)
    {
        $assets = array_flatten(func_get_args());

        // Store the directory instance on a variable that we can inject into the scope of
        // the closure below. This allows us to call the path conversion method.
        $directory = $this;

        $this->assets = $this->assets->filter(function($asset) use ($assets, $directory)
        {
            $path = $directory->getPathRelativeToDirectory($asset->getRelativePath());

            return in_array($path, $assets);
        });

        return $this;
    }

    /**
     * Get a path relative from the current directory's path.
     * 
     * @param  string  $path
     * @return string
     */
    public function getPathRelativeToDirectory($path)
    {
        // Get the last segment of the directory as asset paths will be relative to this
        // path. We can then replace this segment with nothing in the assets path.
        $directoryLastSegment = substr($this->path, strrpos($this->path, '/') + 1);

        return trim(preg_replace('/^'.$directoryLastSegment.'/', '', $path), '/');
    }

    /**
     * All assets within directory will be served raw.
     * 
     * @return \Basset\Directory
     */
    public function raw()
    {
        $this->assets->each(function($asset) { $asset->raw(); });

        return $this;
    }

    /**
     * All assets within directory will be served raw on a given environment.
     * 
     * @return \Basset\Directory
     */
    public function rawOnEnvironment($environment)
    {
        $this->assets->each(function($asset) use ($environment) { $asset->rawOnEnvironment($environment); });

        return $this;
    }

    /**
     * Get the path to the directory.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get all the assets.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAssets()
    {
        $assets = $this->assets;

        // Spin through each directory and recursively merge the current directories assets
        // on to the directories assets. This maintains the order of adding in the array
        // structure.
        $this->directories->each(function($directory) use (&$assets)
        {
            $assets = $directory->getAssets()->merge($assets);
        });

        // Spin through each of the filters and apply them to each of the assets. Every filter
        // is applied and then later during the build will be removed if it does not apply
        // to a given asset.
        $this->filters->each(function($filter) use (&$assets)
        {
            $assets->each(function($asset) use ($filter) { $asset->apply($filter); });
        });

        return $assets;
    }

    /**
     * Get the current directories assets.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getDirectoryAssets()
    {
        return $this->assets;
    }
    
}