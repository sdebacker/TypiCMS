<?php namespace Basset\Builder;

use Basset\Collection;
use Basset\Manifest\Manifest;
use Illuminate\Filesystem\Filesystem;
use Basset\Exceptions\BuildNotRequiredException;

class Builder {

    /**
     * Illuminate filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Basset manifest instance.
     * 
     * @var \Basset\Manifest\Manifest
     */
    protected $manifest;

    /**
     * Path to built collections.
     * 
     * @var string
     */
    protected $buildPath;

    /**
     * Indicates if the build will be pre-gzipped.
     * 
     * @var bool
     */
    protected $gzip = false;

    /**
     * Indicates if the build will be forced.
     * 
     * @var bool
     */
    protected $force = false;

    /**
     * Create a new builder instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Basset\Manifest\Manifest  $manifest
     * @param  \Basset\Builder\FilesystemCleaner  $cleaner
     * @param  string  $buildPath
     * @return void
     */
    public function __construct(Filesystem $files, Manifest $manifest, $buildPath)
    {
        $this->files = $files;
        $this->manifest = $manifest;
        $this->buildPath = $buildPath;

        $this->makeBuildPath();
    }

    /**
     * Build a production collection.
     * 
     * @param  \Basset\Collection  $collection
     * @param  string  $group
     * @return void
     * @throws \Basset\Exceptions\BuildNotRequiredException
     */
    public function buildAsProduction(Collection $collection, $group)
    {
        // Get the assets of the given group from the collection. The collection is also responsible
        // for handling any ordering of the assets so that we just need to build them.
        $assets = $collection->getAssetsWithoutRaw($group);

        $entry = $this->manifest->make($identifier = $collection->getIdentifier());

        // Build the assets and transform the array into a newline separated string. We'll use this
        // as a basis for the collections fingerprint and it will decide as to whether the
        // collection needs to be rebuilt.
        $build = array_to_newlines($assets->map(function($asset) { return $asset->build(true); })->all());

        // If the build is empty then we'll reset the fingerprint on the manifest entry and throw the
        // exception as there's no point going any further.
        if (empty($build))
        {
            $entry->resetProductionFingerprint($group);

            throw new BuildNotRequiredException;
        }

        $fingerprint = $identifier.'-'.md5($build).'.'.$collection->getExtension($group);

        $path = $this->buildPath.'/'.$fingerprint;

        // If the collection has already been built and we're not forcing the build then we'll throw
        // the exception here as we don't need to rebuild the collection.
        if ($fingerprint == $entry->getProductionFingerprint($group) and ! $this->force and $this->files->exists($path))
        {
            throw new BuildNotRequiredException;
        }
        else
        {
            $this->files->put($path, $this->gzip($build));

            $entry->setProductionFingerprint($group, $fingerprint);
        }
    }

    /**
     * Build a development collection.
     * 
     * @param  \Basset\Collection  $collection
     * @param  string  $group
     * @return void
     * @throws \Basset\Exceptions\BuildNotRequiredException
     */
    public function buildAsDevelopment(Collection $collection, $group)
    {
        // Get the assets of the given group from the collection. The collection is also responsible
        // for handling any ordering of the assets so that we just need to build them.
        $assets = $collection->getAssetsWithoutRaw($group);

        $entry = $this->manifest->make($identifier = $collection->getIdentifier());

        // If the collection definition has changed when compared to the manifest entry or if the
        // collection is being forcefully rebuilt then we'll reset the development assets.
        if ($this->collectionDefinitionHasChanged($assets, $entry, $group) or $this->force)
        {
            $entry->resetDevelopmentAssets($group);
        }

        // Otherwise we'll look at each of the assets and see if the entry has the asset or if
        // the assets build path differs from that of the manifest entry.
        else
        {
            $assets = $assets->filter(function($asset) use ($entry)
            {
                return ! $entry->hasDevelopmentAsset($asset) or $asset->getBuildPath() != $entry->getDevelopmentAsset($asset);
            });
        }

        if ( ! $assets->isEmpty())
        {
            foreach ($assets as $asset)
            {
                $path = "{$this->buildPath}/{$identifier}/{$asset->getBuildPath()}";

                // If the build directory does not exist we'll attempt to recursively create it so we can
                // build the asset to the directory.
                ! $this->files->exists($directory = dirname($path)) and $this->files->makeDirectory($directory, 0777, true);

                $this->files->put($path, $this->gzip($asset->build()));

                // Add the development asset to the manifest entry so that we can save the built asset
                // to the manifest.
                $entry->addDevelopmentAsset($asset);
            }
        }
        else
        {
            throw new BuildNotRequiredException;
        }
    }

    /**
     * Determine if the collections definition has changed when compared to the manifest.
     * 
     * @param  \Illuminate\Support\Collection  $assets
     * @param  \Basset\Manifest\Entry  $entry
     * @param  string  $group
     * @return bool
     */
    protected function collectionDefinitionHasChanged($assets, $entry, $group)
    {
        // If the manifest entry doesn't even have the group registered then it's obvious that the
        // collection has changed and needs to be rebuilt.
        if ( ! $entry->hasDevelopmentAssets($group))
        {
            return true;
        }

        // Get the development assets from the manifest entry and flatten the keys so that we have
        // an array of relative paths that we can compare from.
        $manifest = $entry->getDevelopmentAssets($group);

        $manifest = array_flatten(array_keys($manifest));

        // Compute the difference between the collections assets and the manifests assets. If we get
        // an array of values then the collection has changed since the last build and everything
        // should be rebuilt.
        $difference = array_diff_assoc($manifest, $assets->map(function($asset) { return $asset->getRelativePath(); })->flatten()->toArray());

        return ! empty($difference);
    }

    /**
     * Make the build path if it does not exist.
     * 
     * @return void
     */
    protected function makeBuildPath()
    {
        if ( ! $this->files->exists($this->buildPath))
        {
            $this->files->makeDirectory($this->buildPath);
        }
    }

    /**
     * If Gzipping is enabled the the zlib extension is loaded we'll Gzip the contents
     * with a maximum compression level of 9.
     * 
     * @param  string  $contents
     * @return string
     */
    protected function gzip($contents)
    {
        if ($this->gzip and function_exists('gzencode'))
        {
            return gzencode($contents, 9);
        }

        return $contents;
    }

    /**
     * Set built collections to be gzipped.
     * 
     * @param  bool  $gzip
     * @return \Basset\Builder\Builder
     */
    public function setGzip($gzip)
    {
        $this->gzip = $gzip;

        return $this;
    }

    /**
     * Set the building to be forced.
     *
     * @param  bool  $force
     * @return \Basset\Builder\Builder
     */
    public function setForce($force)
    {
        $this->force = $force;

        return $this;
    }

}
