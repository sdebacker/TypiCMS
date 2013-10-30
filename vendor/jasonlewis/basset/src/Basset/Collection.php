<?php namespace Basset;

class Collection {

    /**
     * The default directory of the collection.
     * 
     * @var \Basset\Directory
     */
    protected $directory;
    
    /**
     * The collection identifier.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Create a new collection instance.
     *
     * @param  string  $identifier
     * @param  \Basset\Directory  $directory
     * @return void
     */
    public function __construct(Directory $directory, $identifier)
    {
        $this->directory = $directory;
        $this->identifier = $identifier;
    }

    /**
     * Get all the assets filtered by a group and without the raw assets.
     * 
     * @param  string  $group
     * @return \Illuminate\Support\Collection
     */
    public function getAssetsWithoutRaw($group = null)
    {
        return $this->getAssets($group, false);
    }

    /**
     * Get all the assets filtered by a group and with the raw assets.
     *
     * @param  string  $group
     * @return \Illuminate\Support\Collection
     */
    public function getAssetsWithRaw($group = null)
    {
        return $this->getAssets($group, true);
    }

    /**
     * Get all the assets filtered by a group but only if the assets are raw.
     *
     * @param  string  $group
     * @return \Illuminate\Support\Collection
     */
    public function getAssetsOnlyRaw($group = null)
    {
        // Get all the assets for the given group and filter out assets that aren't listed
        // as being raw.
        $assets = $this->getAssets($group, true)->filter(function($asset)
        {
            return $asset->isRaw();
        });

        return $assets;
    }

    /**
     * Get all the assets filtered by a group and if to include the raw assets.
     *
     * @param  string  $group
     * @param  bool  $raw
     * @return \Illuminate\Support\Collection
     */
    public function getAssets($group = null, $raw = true)
    {
        // Spin through all of the assets that belong to the given group and push them on
        // to the end of the array.
        $assets = clone $this->directory->getAssets();

        foreach ($assets as $key => $asset)
        {
            if ( ! $raw and $asset->isRaw() or ! is_null($group) and ! $asset->{'is'.ucfirst(str_singular($group))}())
            {
                $assets->forget($key);
            }
        }

        // Spin through each of the assets and build an ordered array of assets. Once
        // we have the ordered array we'll transform it into a collection and apply
        // the collection wide filters to each asset.
        $ordered = array();

        foreach ($assets as $asset)
        {
            $this->orderAsset($asset, $ordered);
        }

        return new \Illuminate\Support\Collection($ordered);
    }

    /**
     * Orders the array of assets as they were defined or on a user ordered basis.
     * 
     * @param  \Basset\Asset  $asset
     * @param  array  $assets
     * @return void
     */
    protected function orderAsset(Asset $asset, array &$assets)
    {
        $order = $asset->getOrder() and $order--;

        // If an asset already exists at the given order key then we'll add one to the order
        // so the asset essentially appears after the existing asset. This makes sense since
        // the array of assets has been reversed, so if the last asset was told to be first
        // then when we finally get to the first added asset it's added second.
        if (array_key_exists($order, $assets))
        {
            array_splice($assets, $order, 0, array(null));
        }

        $assets[$order] = $asset;

        ksort($assets);
    }

    /**
     * Get the identifier of the collection.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get the default directory.
     * 
     * @return \Basset\Directory
     */
    public function getDefaultDirectory()
    {
        return $this->directory;
    }

    /**
     * Determine an extension based on the group.
     *
     * @param  string  $group
     * @return string
     */
    public function getExtension($group)
    {
        return str_plural($group) == 'stylesheets' ? 'css' : 'js';
    }

    /**
     * Dynamically call methods on the default directory.
     * 
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->directory, $method), $parameters);
    }

}