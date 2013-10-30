<?php namespace Basset;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Basset\Exceptions\AssetExistsException;
use Basset\Exceptions\AssetNotFoundException;
use Basset\Exceptions\DirectoryNotFoundException;

class AssetFinder {

    /**
     * Illuminate filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Illuminate config repository instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Working directory stack.
     *
     * @var string
     */
    protected $directoryStack = array();

    /**
     * Array of package namespace hints.
     * 
     * @var array
     */
    protected $hints = array();

    /**
     * Create a new asset finder instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Config\Repository  $config
     * @param  string  $publicPath
     * @return void
     */
    public function __construct(Filesystem $files, Repository $config, $publicPath)
    {
        $this->files = $files;
        $this->config = $config;
        $this->publicPath = $publicPath;
    }

    /**
     * Find and return an assets path.
     *
     * @param  string  $name
     * @return string
     * @throws \Basset\Exceptions\AssetExistsException
     * @throws \Basset\Exceptions\AssetNotFoundException
     */
    public function find($name)
    {
        $name = $this->config->get("basset::aliases.assets.{$name}", $name);

        // Spin through an array of methods ordered by the priority of how an asset should be found.
        // Once we find a non-null path we'll return that path breaking from the loop.
        foreach (array('RemotelyHosted', 'PackageAsset', 'WorkingDirectory', 'PublicPath', 'AbsolutePath') as $method)
        {
            if ($path = $this->{'find'.$method}($name))
            {
                return $path;
            }
        }

        throw new AssetNotFoundException;
    }

    /**
     * Find a remotely hosted asset.
     *
     * @param  string  $name
     * @return null|string
     */
    public function findRemotelyHosted($name)
    {
        if (filter_var($name, FILTER_VALIDATE_URL) or starts_with($name, '//'))
        {
            return $name;
        }
    }

    /**
     * Find an asset by looking for a prefixed package namespace.
     *
     * @param  string  $name
     * @return null|string
     */
    public function findPackageAsset($name)
    {
        if (str_contains($name, '::'))
        {
            list($namespace, $name) = explode('::', $name);

            if ( ! isset($this->hints[$namespace]))
            {
                return;
            }

            $path = $this->prefixPublicPath('packages/'.$this->hints[$namespace].'/'.$name);

            if ($this->files->exists($path))
            {
                return $path;
            }
        }
    }

    /**
     * Find an asset by searching in the current working directory.
     *
     * @param  string  $name
     * @return null|string
     */
    public function findWorkingDirectory($name)
    {
        $path = $this->getWorkingDirectory().'/'.$name;

        if ($this->withinWorkingDirectory() and $this->files->exists($path))
        {
            return $path;
        }
    }

    /**
     * Find an asset by searching in the public path.
     *
     * @param  string  $name
     * @return null|string
     */
    public function findPublicPath($name)
    {
        $path = $this->prefixPublicPath($name);

        if ($this->files->exists($path))
        {
            return $path;
        }
    }

    /**
     * Find an asset by absolute path.
     * 
     * @param  string  $name
     * @return null|string
     */
    public function findAbsolutePath($name)
    {
        if ($this->files->exists($name))
        {
            return $name;
        }
    }

    /**
     * Set the working directory path.
     *
     * @param  string  $path
     * @return string
     * @throws \Basset\Exceptions\DirectoryNotFoundException
     */
    public function setWorkingDirectory($path)
    {
        $path = $this->prefixDirectoryStack($path);

        if ($this->files->exists($path))
        {
            return $this->directoryStack[] = $path;
        }

        throw new DirectoryNotFoundException("Directory [{$path}] could not be found.");
    }

    /**
     * Pop the last directory from the directory stack.
     *
     * @return string
     */
    public function resetWorkingDirectory()
    {
        return array_pop($this->directoryStack);
    }

    /**
     * Determine if within a working directory.
     * 
     * @return bool
     */
    public function withinWorkingDirectory()
    {
        return ! empty($this->directoryStack);
    }

    /**
     * Get the last working directory path off the directory stack.
     *
     * @return string
     */
    public function getWorkingDirectory()
    {
        return end($this->directoryStack);
    }

    /**
     * Get the working directory stack.
     * 
     * @return array
     */
    public function getDirectoryStack()
    {
        return $this->directoryStack;
    }

    /**
     * Prefix the last directory from the stack or the public path if not
     * within a working directory
     * 
     * @param  string  $path
     * @return string
     */
    public function prefixDirectoryStack($path)
    {
        if ($this->withinWorkingDirectory())
        {
            return rtrim($this->getWorkingDirectory().'/'.ltrim($path, '/'), '/');
        }

        return $this->prefixPublicPath($path);
    }

    /**
     * Add a package namespace.
     * 
     * @param  string  $namespace
     * @param  string  $package
     * @return void
     */
    public function addNamespace($namespace, $package)
    {
        $this->hints[$namespace] = $package;
    }

    /**
     * Prefix the public path to a path.
     *
     * @param  string  $path
     * @return string
     */
    protected function prefixPublicPath($path)
    {
        return rtrim($this->publicPath.'/'.ltrim($path, '/'), '/');
    }

    /**
     * Get the public path.
     * 
     * @return string
     */
    public function getPublicPath()
    {
        return $this->publicPath;
    }

}