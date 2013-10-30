<?php namespace Basset\Filter;

use Closure;
use Basset\Asset;
use ReflectionClass;
use ReflectionException;
use Illuminate\Log\Writer;
use Assetic\Filter\FilterInterface;
use Symfony\Component\Process\ExecutableFinder;

class Filter {

    /**
     * Array of instantiation arguments.
     *
     * @var array
     */
    protected $arguments = array();

    /**
     * Array of before filtering callbacks.
     *
     * @var array
     */
    protected $before = array();

    /**
     * Filter name.
     *
     * @var string
     */
    protected $filter;

    /**
     * Resource being filtered.
     *
     * @var \Basset\Filterable
     */
    protected $resource;

    /**
     * Array of filter requirements.
     * 
     * @var array
     */
    protected $requirements = array();

    /**
     * Array of node module paths.
     * 
     * @var array
     */
    protected $nodePaths = array();

    /**
     * Array of valid executable argument suffixes.
     * 
     * @var array
     */
    protected $validSuffixes = array('bin', 'path');

    /**
     * Indicates if the filter should be ignored when building assets.
     * 
     * @var bool
     */
    protected $ignored = false;

    /**
     * Application working environment.
     * 
     * @var string
     */
    protected $appEnvironment;

    /**
     * Illuminate log writer instance.
     * 
     * @var \Illuminate\Log\Writer
     */
    protected $log;

    /**
     * Indicates if the build is a production build.
     * 
     * @var bool
     */
    protected $production = false;

    /**
     * Create a new filter instance.
     *
     * @param  \Illuminate\Log\Writer  $log
     * @param  string  $filter
     * @param  array  $nodePaths
     * @param  string  $appEnvironment
     * @return void
     */
    public function __construct(Writer $log, $filter, array $nodePaths, $appEnvironment)
    {
        $this->log = $log;
        $this->filter = $filter;
        $this->nodePaths = $nodePaths;
        $this->appEnvironment = $appEnvironment;
    }

    /**
     * Find and set any missing constructor arguments.
     * 
     * @return \Basset\Filter\Filter
     */
    public function findMissingConstructorArgs()
    {
        try
        {
            $class = new ReflectionClass($this->getClassName());
        }
        catch (ReflectionException $e)
        {
            return $this;
        }

        if ($constructor = $class->getConstructor())
        {
            $finder = $this->getExecutableFinder();

            // Spin through all of the constructor parameters and for those that we can find the executable
            // path for we'll attempt to locate the executable. If we can't find the path then its more
            // then we'll ignore this filter as it will fail during the build.
            foreach ($constructor->getParameters() as $key => $parameter)
            {
                if ($this->hasArgumentAtPosition($key))
                {
                    continue;
                }

                $snakeParameter = $this->normalizeConstructorParameter($parameter->name);

                list($name, $suffix) = explode('_', $snakeParameter);

                // If the suffix is in the array of valid suffixes we can attempt to locate the parameter
                // first as an environment variable and secondly by recursively searching through our
                // paths defined in PATH. If we can't find it then ignore the filter.
                if (in_array($suffix, $this->validSuffixes))
                {
                    $path = $this->getEnvironmentVariable($snakeParameter) ?: $finder->find($name);

                    if ($path)
                    {
                        $this->setArgument($path, $key);
                    }
                    else
                    {
                        // There was a problem locating the path to the argument, we'll log that the
                        // filter was ignored here so that the developer can debug this better.
                        $this->log->error(sprintf('Failed to find required constructor argument for filter "%s". (%s)', $this->filter, $parameter));

                        $this->ignored = true;
                    }
                }
                elseif(str_is('nodePaths', $parameter->name))
                {
                    $this->setArgument($this->nodePaths, $key);
                }
            }
        }

        return $this;
    }

    /**
     * Get an environment variable.
     * 
     * @param  string  $key
     * @return string|bool
     */
    public function getEnvironmentVariable($key)
    {
        return getenv(strtoupper($key));
    }

    /**
     * Convert a constructor parameter to snake case and all lowercase.
     * 
     * @param  string  $name
     * @return string
     */
    protected function normalizeConstructorParameter($name)
    {
        return strtolower(snake_case($name));
    }

    /**
     * Get an executable finder instance.
     * 
     * @return \Symfony\Component\Process\ExecutableFinder
     */
    public function getExecutableFinder()
    {
        return new ExecutableFinder;
    }

    /**
     * Add a requirement to the filter.
     * 
     * @param  \Closure  $callback
     * @return \Basset\Filter\Filter
     */
    public function when(Closure $callback)
    {
        $this->requirements[] = $callback;

        return $this;
    }

    /**
     * Add a class exists requirement to the filter.
     * 
     * @param  string  $class
     * @return \Basset\Filter\Filter
     */
    public function whenClassExists($class)
    {
        return $this->when(function() use ($class)
        {
            return class_exists($class);
        });
    }

    /**
     * Add a asset name pattern requirement to the filter.
     * 
     * @param  string  $pattern
     * @return \Basset\Filter\Filter
     */
    public function whenAssetIs($pattern)
    {
        return $this->when(function($asset) use ($pattern)
        {
            return (bool) preg_match('#'.$pattern.'#', $asset->getRelativePath());
        });
    }

    /**
     * Add an environment requirement to the filter.
     *
     * @return \Basset\Filter\Filter
     */
    public function whenEnvironmentIs()
    {
        $environments = func_get_args();

        $appEnvironment = $this->appEnvironment;

        return $this->when(function($asset) use ($environments, $appEnvironment)
        {
            return in_array($appEnvironment, $environments);
        });
    }

    /**
     * Add a stylesheets only requirement to the filter.
     *
     * @return \Basset\Filter\Filter
     */
    public function whenAssetIsStylesheet()
    {
        return $this->when(function($asset)
        {
            return $asset->isStylesheet();
        });
    }

    /**
     * Add a javascripts only requirement to the filter.
     *
     * @return \Basset\Filter\Filter
     */
    public function whenAssetIsJavascript()
    {
        return $this->when(function($asset)
        {
            return $asset->isJavascript();
        });
    }

    /**
     * Add a production build requirement to the filter.
     * 
     * @return \Basset\Filter\Filter
     */
    public function whenProductionBuild()
    {
        return $this->when(function($asset, $filter)
        {
            return $filter->getProduction() === true;
        });
    }

    /**
     * Add a development build requirement to the filter.
     * 
     * @return \Basset\Filter\Filter
     */
    public function whenDevelopmentBuild()
    {
        return $this->when(function($asset, $filter)
        {
            return $filter->getProduction() === false;
        });
    }

    /**
     * Add a before filtering callback.
     *
     * @param  \Closure  $callback
     * @return \Basset\Filter\Filter
     */
    public function beforeFiltering(Closure $callback)
    {
        $this->before[] = $callback;

        return $this;
    }

    /**
     * Determine if the filter has an instantiation argument at a given position.
     * 
     * @param  int  $position
     * @return bool
     */
    public function hasArgumentAtPosition($position)
    {
        return isset($this->arguments[$position]);
    }

    /**
     * Set a single instantiation argument.
     * 
     * @param  string  $argument
     * @param  int  $position
     * @return \Basset\Filter\Filter
     */
    public function setArgument($argument, $position = null)
    {
        array_splice($this->arguments, $position ?: count($this->arguments), 0, array($argument));

        return $this;
    }

    /**
     * Set the filters instantiation arguments
     *
     * @return Basset\Filter\Filter
     */
    public function setArguments()
    {
        $this->arguments = func_get_args();

        return $this;
    }

    /**
     * Set the resource on the filter.
     * 
     * @param  \Basset\Filter\Filterable  $resource
     * @return \Basset\Filter\Filter
     */
    public function setResource(Filterable $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get the parent resource.
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Get the array of environments.
     *
     * @return array
     */
    public function getEnvironments()
    {
        return $this->environments;
    }

    /**
     * Get the filters instantiation arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Determine if filter is ignored.
     * 
     * @return bool
     */
    public function isIgnored()
    {
        return $this->ignored;
    }

    /**
     * Get the class name for the filter if it exists.
     *
     * @return string
     */
    public function getClassName()
    {
        if (class_exists("Assetic\\Filter\\{$this->filter}"))
        {
            return "Assetic\\Filter\\{$this->filter}";
        }
        elseif (class_exists("Basset\\Filter\\{$this->filter}"))
        {
            return "Basset\\Filter\\{$this->filter}";
        }
    }

    /**
     * Attempt to instantiate the filter if it exists and has not been ignored.
     *
     * @return null|\Assetic\Filter\FilterInterface
     */
    public function getInstance()
    {
        if ( ! $class = $this->getClassName())
        {
            $this->log->error(sprintf('"%s" will not be applied to asset "%s" due to an invalid filter name.', $this->filter, $this->resource->getRelativePath()));
        }

        if ($this->ignored or is_null($class) or ! $this->processRequirements()) return;

        // If the class returned is already implements Assetic\Filter\FilterInterface then
        // we can set the instance directly and not worry about using reflection.
        if ($class instanceof FilterInterface)
        {
            $instance = $class;
        }
        else
        {
            $reflection = new ReflectionClass($class);

            // If no constructor is available on the filters class then we'll instantiate
            // the filter without passing in any arguments.
            if ( ! $reflection->getConstructor())
            {
                $instance = $reflection->newInstance();
            }
            else
            {
                $instance = $reflection->newInstanceArgs($this->arguments);
            }
        }

        // Spin through each of the before filtering callbacks and fire each one. We'll
        // pass in an instance of the filter to the callback.
        foreach ($this->before as $callback)
        {
            if (is_callable($callback))
            {
                call_user_func($callback, $instance);
            }
        }

        return $instance;
    }

    /**
     * Process any requirements on the filter.
     * 
     * @return bool
     */
    public function processRequirements()
    {
        foreach ($this->requirements as $requirement)
        {
            if ( ! call_user_func($requirement, $this->resource, $this))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the filter requirements.
     * 
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Set the production build indicator.
     * 
     * @param  bool  $production
     * @return \Basset\Filter\Filter
     */
    public function setProduction($production)
    {
        $this->production = $production;

        return $this;
    }

    /**
     * Get the production build indicator.
     * 
     * @return bool
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * Get the array of node paths.
     * 
     * @return array
     */
    public function getNodePaths()
    {
        return $this->nodePaths;
    }

    /**
     * Dynamically chain uncallable methods to the belonging resource.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // If the method starts with "andWhen" then we'll call the method without
        // the "and" as this provides some syntactical sugar when chaining
        // filter requirements.
        if (starts_with($method, 'andWhen'))
        {
            $method = lcfirst(substr($method, 3));
            
            return call_user_func_array(array($this, $method), $parameters);
        }

        return call_user_func_array(array($this->resource, $method), $parameters);
    }

}