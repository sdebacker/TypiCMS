<?php namespace Basset\Filter;

use Closure;

abstract class Filterable {

    /**
     * Collection of filters.
     * 
     * @var \Illuminate\Support\Collection
     */
    protected $filters;

    /**
     * Create a new filterable instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->filters = new \Illuminate\Support\Collection;
    }

    /**
     * Syntatical sugar for chaining filters.
     * 
     * @param  string|array  $filter
     * @param  \Closure  $callback
     * @return \Basset\Filter\Filter|\Basset\Filter\Filterable
     */
    public function andApply($filter, Closure $callback = null)
    {
        return $this->apply($filter, $callback);
    }

    /**
     * Apply a filter.
     *
     * @param  string|array  $filter
     * @param  \Closure  $callback
     * @return \Basset\Filter\Filter|\Basset\Filter\Filterable
     */
    public function apply($filter, Closure $callback = null)
    {
        // If the supplied filter is an array then we'll treat it as an array of filters that are
        // to be applied to the resource.
        if (is_array($filter))
        {
            return $this->applyFromArray($filter);
        }

        $filter = $this->factory->get('filter')->make($filter)->setResource($this);

        is_callable($callback) and call_user_func($callback, $filter);

        return $this->filters[$filter->getFilter()] = $filter;
    }

    /**
     * Apply filter from an array of filters.
     * 
     * @param  array  $filters
     * @return \Basset\Filter\Filterable
     */
    public function applyFromArray($filters)
    {
        foreach ($filters as $key => $value)
        {
            $filter = $this->factory->get('filter')->make(is_callable($value) ? $key : $value)->setResource($this);

            is_callable($value) and call_user_func($value, $filter);

            $this->filters[$filter->getFilter()] = $filter;
        }

        return $this;
    }

    /**
     * Get the applied filters.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Get the log writer instance.
     * 
     * @return \Illumiante\Log\Writer
     */
    public function getLogger()
    {
        return $this->factory->getLogger();
    }

}