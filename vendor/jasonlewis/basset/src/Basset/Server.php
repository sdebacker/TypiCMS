<?php namespace Basset;

use Basset\Collection;
use Basset\Manifest\Entry;
use Basset\Manifest\Manifest;
use Basset\Exceptions\BuildNotRequiredException;

class Server {

    /**
     * Laravel application instance.
     * 
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Create a new output server instance.
     *
     * @param  \Illuminate\Foundation\Application
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Serve a collection where the group is determined by the the extension.
     * 
     * @param  string  $collection
     * @param  string  $format
     * @return string
     */
    public function collection($collection, $format = null)
    {
        list($collection, $extension) = preg_split('/\.(css|js)/', $collection, 2, PREG_SPLIT_DELIM_CAPTURE);

        $group = $extension == 'css' ? 'stylesheets' : 'javascripts';

        return $this->serve($collection, $group, $format);
    }

    /**
     * Serve the stylesheets for a given collection.
     *
     * @param  string  $collection
     * @param  string  $format
     * @return string
     */
    public function stylesheets($collection, $format = null)
    {
        return $this->serve($collection, 'stylesheets', $format);
    }

    /**
     * Serve the javascripts for a given collection.
     *
     * @param  string  $collection
     * @param  string  $format
     * @return string
     */
    public function javascripts($collection, $format = null)
    {
        return $this->serve($collection, 'javascripts', $format);
    }

    /**
     * Serve a given group for a collection.
     *
     * @param  string  $collection
     * @param  string  $group
     * @param  string  $format
     * @return string
     */
    public function serve($collection, $group, $format = null)
    {
        if ( ! isset($this->app['basset'][$collection]))
        {
            return '<!-- Basset could not find collection: '.$collection.' -->';
        }

        // Get the collection instance from the array of collections. This instance will be used
        // throughout the building process to fetch assets and compare against the stored
        // manfiest of fingerprints.
        $collection = $this->app['basset'][$collection];

        if ($this->runningInProduction() and $this->app['basset.manifest']->has($collection))
        {
            if ($this->app['basset.manifest']->get($collection)->hasProductionFingerprint($group))
            {
                return $this->serveProductionCollection($collection, $group, $format);
            }
        }

        return $this->serveDevelopmentCollection($collection, $group, $format);
    }

    /**
     * Serve a production collection.
     *
     * @param  \Basset\Collection  $collection
     * @param  string  $group
     * @param  string  $format
     * @return array
     */
    protected function serveProductionCollection(Collection $collection, $group, $format)
    {
        $entry = $this->getCollectionEntry($collection);

        $fingerprint = $entry->getProductionFingerprint($group);

        $production = $this->{'create'.studly_case($group).'Element'}($this->prefixBuildPath($fingerprint), $format);

        return $this->formatResponse($this->serveRawAssets($collection, $group, $format), $production);
    }

    /**
     * Serve a development collection.
     * 
     * @param  \Basset\Collection  $collection
     * @param  string  $group
     * @param  string  $format
     * @return array
     */
    protected function serveDevelopmentCollection(Collection $collection, $group, $format)
    {
        $identifier = $collection->getIdentifier();

        // Before we fetch the collections manifest entry we'll try to build the collection
        // again if there is anything outstanding. This doesn't have a huge impact on
        // page loads time like trying to dynamically serve each asset.
        $this->tryDevelopmentBuild($collection, $group);

        $entry = $this->getCollectionEntry($collection);

        $responses = array();

        foreach ($collection->getAssetsWithRaw($group) as $asset)
        {
            if ( ! $asset->isRaw() and $path = $entry->getDevelopmentAsset($asset))
            {
                $path = $this->prefixBuildPath($identifier.'/'.$path);
            }
            else
            {
                $path = $asset->getRelativePath();
            }

            $responses[] = $this->{'create'.studly_case($group).'Element'}($path, $format);
        }

        return $this->formatResponse($responses);
    }

    /**
     * Serve a collections raw assets.
     *
     * @param  \Basset\Collection  $collection
     * @param  string  $group
     * @param  string  $format
     * @return array
     */
    protected function serveRawAssets(Collection $collection, $group, $format)
    {
        $responses = array();

        foreach ($collection->getAssetsOnlyRaw($group) as $asset)
        {
            $path = $asset->getRelativePath();

            $responses[] = $this->{'create'.studly_case($group).'Element'}($path, $format);
        }

        return $responses;
    }

    /**
     * Format an array of responses and return a string.
     * 
     * @param  mixed  $args
     * @return string
     */
    protected function formatResponse()
    {
        $responses = array();

        foreach (func_get_args() as $response)
        {
            $responses = array_merge($responses, (array) $response);
        }

        return array_to_newlines($responses);
    }

    /**
     * Get a collection manifest entry.
     * 
     * @param  \Basset\Collection  $collection
     * @return \Basset\Manifest\Entry
     */
    protected function getCollectionEntry(Collection $collection)
    {
        return $this->app['basset.manifest']->get($collection);
    }

    /**
     * Try the development build of a collection.
     * 
     * @param  \Basset\Collection  $collection
     * @param  string  $group
     * @return void
     */
    protected function tryDevelopmentBuild(Collection $collection, $group)
    {
        try
        {
            $this->app['basset.builder']->buildAsDevelopment($collection, $group);
        }
        catch (BuildNotRequiredException $e) {}

        $this->app['basset.builder.cleaner']->clean($collection->getIdentifier());
    }

    /**
     * Prefix the build path to a given path.
     * 
     * @param  string  $path
     * @return string
     */
    protected function prefixBuildPath($path)
    {
        if ($buildPath = $this->app['config']->get('basset::build_path'))
        {
            $path = "{$buildPath}/{$path}";
        }

        return $path;
    }

    /**
     * Determine if the application is running in production mode.
     * 
     * @return bool
     */
    protected function runningInProduction()
    {
        return in_array($this->app['env'], (array) $this->app['config']->get('basset::production'));
    }

    /**
     * Create a stylesheets element for the specified path.
     *
     * @param  string  $path
     * @param  string  $format
     * @return string
     */
    protected function createStylesheetsElement($path, $format)
    {
        return sprintf($format ?: '<link rel="stylesheet" type="text/css" href="%s" />', $this->buildAssetUrl($path));
    }

    /**
     * Create a javascripts element for the specified path.
     *
     * @param  string  $path
     * @param  string  $format
     * @return string
     */
    protected function createJavascriptsElement($path, $format)
    {
        return sprintf($format ?: '<script src="%s"></script>', $this->buildAssetUrl($path));
    }

    /**
     * Build the URL to an asset.
     * 
     * @param  string  $path
     * @return string
     */
    public function buildAssetUrl($path)
    {
        return starts_with($path, '//') ? $path : $this->app['url']->asset($path);
    }

}
