<?php namespace Basset;

use Closure;
use ArrayAccess;
use InvalidArgumentException;
use Basset\Factory\FactoryManager;

class Environment implements ArrayAccess {

    /**
     * Asset collections.
     *
     * @var array
     */
    protected $collections = array();

    /**
     * Basset factory manager instance.
     *
     * @var \Basset\Factory\FactoryManager
     */
    protected $factory;

    /**
     * Asset finder instance.
     *
     * @var \Basset\AssetFinder
     */
    protected $finder;

    /**
     * Create a new environment instance.
     *
     * @param  \Basset\Factory\FactoryManager  $factory
     * @param  \Basset\AssetFinder  $finder
     * @return void
     */
    public function __construct(FactoryManager $factory, AssetFinder $finder)
    {
        $this->factory = $factory;
        $this->finder = $finder;
    }

    /**
     * Alias of \Basset\Environment::collection()
     *
     * @param  string  $name
     * @param  \Closure  $callback
     * @return \Basset\Collection
     */
    public function make($name, Closure $callback = null)
    {
        return $this->collection($name, $callback);
    }

    /**
     * Create or return an existing collection.
     *
     * @param  string  $identifier
     * @param  \Closure  $callback
     * @return \Basset\Collection
     */
    public function collection($identifier, Closure $callback = null)
    {
        if ( ! isset($this->collections[$identifier]))
        {
            $directory = $this->prepareDefaultDirectory();

            $this->collections[$identifier] = new Collection($directory, $identifier);
        }

        // If the collection has been given a callable closure then we'll execute the closure with
        // the collection instance being the only parameter given. This allows users to begin
        // using the collection instance to add assets.
        if (is_callable($callback))
        {
            call_user_func($callback, $this->collections[$identifier]);
        }

        return $this->collections[$identifier];
    }

    /**
     * Prepare the default directory for a new collection.
     * 
     * @return \Basset\Directory
     */
    protected function prepareDefaultDirectory()
    {
        $path = $this->finder->setWorkingDirectory('/');

        return new Directory($this->factory, $this->finder, $path);
    }

    /**
     * Get all collections.
     *
     * @return array
     */
    public function all()
    {
        return $this->collections;
    }

    /**
     * Determine if a collection exists.
     *
     * @param  string  $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->collections[$name]);
    }

    /**
     * Register a package with the environment.
     * 
     * @param  string  $package
     * @param  string  $namespace
     * @return void
     */
    public function package($package, $namespace = null)
    {
        if (is_null($namespace))
        {
            list($vendor, $namespace) = explode('/', $package);
        }

        $this->finder->addNamespace($namespace, $package);
    }

    /**
     * Register an array of collections.
     * 
     * @param  array  $collections
     * @return void
     */
    public function collections(array $collections)
    {
        foreach ($collections as $name => $callback)
        {
            $this->make($name, $callback);
        }
    }

    /**
     * Set a collection offset.
     *
     * @param  string  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            throw new InvalidArgumentException('Collection identifier not given.');
        }

        $this->collection($offset, $value);
    }

    /**
     * Get a collection offset.
     *
     * @param  string  $offset
     * @return null|\Basset\Collection
     */
    public function offsetGet($offset)
    {
        return $this->has($offset) ? $this->collection($offset) : null;
    }

    /**
     * Unset a collection offset.
     *
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->collections[$offset]);
    }

    /**
     * Determine if a collection offset exists.
     *
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

}