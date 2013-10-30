<?php namespace Basset\Factory;

use Basset\Filter\Filter;
use Basset\Filter\FilterableInterface;

class FilterFactory extends Factory {

    /**
     * Array of filter aliases.
     * 
     * @var array
     */
    protected $aliases = array();

    /**
     * Array of node paths.
     * 
     * @var array
     */
    protected $nodePaths = array();

    /**
     * Application working environment.
     * 
     * @var string
     */
    protected $appEnvironment;

    /**
     * Create a new filter factory instance.
     * 
     * @param  array  $aliases
     * @param  array  $nodePaths
     * @param  string  $appEnvironment
     * @return void
     */
    public function __construct(array $aliases, array $nodePaths, $appEnvironment)
    {
        $this->aliases = $aliases;
        $this->nodePaths = $nodePaths;
        $this->appEnvironment = $appEnvironment;
    }

    /**
     * Make a new filter instance.
     *
     * @param  string|\Basset\Filter\Filter  $filter
     * @return \Basset\Filter\Filter
     */
    public function make($filter)
    {
        if ($filter instanceof Filter)
        {
            return $filter;
        }
        
        $filter = isset($this->aliases[$filter]) ? $this->aliases[$filter] : $filter;

        if (is_array($filter))
        {
            list($filter, $callback) = array(current($filter), next($filter));
        }

        // If the filter was aliased and the value of the array was a callable closure then
        // we'll return and fire the callback on the filter instance so that any arguments
        // can be set for the filters constructor.
        $filter = new Filter($this->log, $filter, $this->nodePaths, $this->appEnvironment);

        if (isset($callback) and is_callable($callback))
        {
            call_user_func($callback, $filter);
        }

        return $filter;
    }

}