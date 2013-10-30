<?php namespace Basset\Builder;

use Basset\Collection;
use Basset\Environment;
use Basset\Manifest\Entry;
use Basset\Manifest\Manifest;
use Illuminate\Filesystem\Filesystem;

class FilesystemCleaner {

    /**
     * Basset environment instance.
     * 
     * @var \Basset\Environment
     */
    protected $environment;

    /**
     * Basset manifest instance.
     *
     * @var \Basset\Manifest\Manifest
     */
    protected $manifest;

    /**
     * Illuminate filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Path to built collections.
     *
     * @var string
     */
    protected $buildPath;

    /**
     * Create a new build cleaner instance.
     *
     * @param  \Basset\Environment  $environment
     * @param  \Basset\Manifest\Manifest  $manifest
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $buildPath
     * @return void
     */
    public function __construct(Environment $environment, Manifest $manifest, Filesystem $files, $buildPath)
    {
        $this->environment = $environment;
        $this->manifest = $manifest;
        $this->files = $files;
        $this->buildPath = $buildPath;
    }

    /**
     * Clean all built collections and the manifest entries.
     * 
     * @return void
     */
    public function cleanAll()
    {
        $collections = array_keys($this->environment->all()) + array_keys($this->manifest->all());

        foreach ($collections as $collection)
        {
            $this->clean($collection);
        }
    }

    /**
     * Cleans a built collection and the manifest entries.
     *
     * @param  string  $collection
     * @return void
     */
    public function clean($collection)
    {
        $entry = $this->manifest->get($collection);

        // If the collection exists on the environment then we'll proceed with cleaning the filesystem
        // This removes any double-up production and development builds.
        if (isset($this->environment[$collection]))
        {
            $this->cleanFilesystem($this->environment[$collection], $entry);
        }

        // If the collection does not exist on the environment then we'll instrcut the manifest to
        // forget this collection.
        else
        {
            $this->manifest->forget($collection);
        }

        // Cleaning the manifest is important as it will also remove unnecessary files from the
        // filesystem if a collection has been removed.
        $this->cleanManifestFiles($collection, $entry);

        $this->manifest->save();
    }

    /**
     * Cleans a built collections files removing any outdated builds.
     * 
     * @param  \Basset\Collection  $collection
     * @param  \Basset\Manifest\Entry  $entry
     * @return void
     */
    protected function cleanFilesystem(Collection $collection, Entry $entry)
    {
        $this->cleanProductionFiles($collection, $entry);

        $this->cleanDevelopmentFiles($collection, $entry);
    }

    /**
     * Clean the collections manifest entry files.
     * 
     * @param  string  $collection
     * @param  \Basset\Manifest\Entry  $entry
     * @return void
     */
    protected function cleanManifestFiles($collection, Entry $entry)
    {
        if ( ! $entry->hasProductionFingerprints() or ! isset($this->environment[$collection]))
        {
            $this->deleteMatchingFiles($this->buildPath.'/'.$collection.'-*.*');

            $entry->resetProductionFingerprints();
        }

        if ( ! $entry->hasDevelopmentAssets() or ! isset($this->environment[$collection]))
        {
            $this->files->deleteDirectory($this->buildPath.'/'.$collection);

            $entry->resetDevelopmentAssets();
        }
    }

    /**
     * Clean collection production files.
     * 
     * @param  \Basset\Collection  $collection
     * @param  \Basset\Manifest\Entry  $entry
     * @return void
     */
    protected function cleanProductionFiles(Collection $collection, Entry $entry)
    {
        foreach ($entry->getProductionFingerprints() as $fingerprint)
        {
            $wildcardPath = $this->replaceFingerprintWithWildcard($fingerprint);

            $this->deleteMatchingFiles($this->buildPath.'/'.$wildcardPath, $fingerprint);
        }
    }

    /**
     * Clean collection development files.
     * 
     * @param  \Basset\Collection  $collection
     * @param  \Basset\Manifest\Entry  $entry
     * @return void
     */
    protected function cleanDevelopmentFiles(Collection $collection, Entry $entry)
    {
        foreach ($entry->getDevelopmentAssets() as $assets)
        {
            foreach ($assets as $asset)
            {
                $wildcardPath = $this->replaceFingerprintWithWildcard($asset);

                $this->deleteMatchingFiles($this->buildPath.'/'.$collection->getIdentifier().'/'.$wildcardPath, array_values($assets));
            }
        }
    }

    /**
     * Delete matching files from the wildcard glob search except the ignored file.
     * 
     * @param  string  $wildcard
     * @param  array|string  $ignored
     * @return void
     */
    protected function deleteMatchingFiles($wildcard, $ignored = null)
    {
        if (is_array($files = $this->files->glob($wildcard)))
        {
            foreach ($files as $path)
            {
                if ( ! is_null($ignored))
                {
                    // Spin through each of the ignored assets and if the current file path ends
                    // with any of the ignored asset paths then we'll skip this asset as it
                    // needs to be kept.
                    foreach ((array) $ignored as $ignore)
                    {
                        if (ends_with($path, $ignore)) continue 2;
                    }
                }

                $this->files->delete($path);
            }
        }
        
    }

    /**
     * Replace a fingerprint with a wildcard.
     * 
     * @param  string  $value
     * @return string
     */
    protected function replaceFingerprintWithWildcard($value)
    {
        return preg_replace('/(.*?)-([\w\d]{32})\.(.*?)/', '$1-*.$3', $value);
    }

}