<?php namespace Basset\Manifest;

use Basset\Asset;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\ArrayableInterface;

class Entry implements JsonableInterface, ArrayableInterface {

    /**
     * Entry fingerprints.
     *
     * @var array
     */
    protected $fingerprints = array();

    /**
     * Development assets.
     * 
     * @var array
     */
    protected $development = array();

    /**
     * Create a new manifest entry instance.
     *
     * @param  array  $fingerprints
     * @param  array  $development
     * @return void
     */
    public function __construct($fingerprints = array(), $development = array())
    {
        $this->fingerprints = $fingerprints;
        $this->development = $development;
    }

    /**
     * Add a development asset.
     * 
     * @param  string|\Basset\Asset  $value
     * @param  string  $fingerprint
     * @param  string  $group
     * @return void
     */
    public function addDevelopmentAsset($value, $fingerprint = null, $group = null)
    {
        if ($value instanceof Asset)
        {
            $group = $value->getGroup();

            $fingerprint = $value->getBuildPath();

            $value = $value->getRelativePath();
        }

        $this->development[$group][$value] = $fingerprint;
    }

    /**
     * Get a development assets build path.
     * 
     * @param  string|\Basset\Asset  $value
     * @param  string  $group
     * @return null|string
     */
    public function getDevelopmentAsset($value, $group = null)
    {
        if ($value instanceof Asset)
        {
            $group = $value->getGroup();

            $value = $value->getRelativePath();
        }
        
        return isset($this->development[$group][$value]) ? $this->development[$group][$value] : null;
    }

    /**
     * Determine if the entry has a development asset.
     * 
     * @param  string|\Basset\Asset  $value
     * @param  string  $group
     * @return bool
     */
    public function hasDevelopmentAsset($value, $group = null)
    {
        return ! is_null($this->getDevelopmentAsset($value, $group));
    }

    /**
     * Get all or a subset of development assets.
     * 
     * @param  string  $group
     * @return array
     */
    public function getDevelopmentAssets($group = null)
    {
        return is_null($group) ? $this->development : $this->development[$group];
    }

    /**
     * Determine if the entry has any development assets.
     * 
     * @param  string  $group
     * @return bool
     */
    public function hasDevelopmentAssets($group = null)
    {
        return is_null($group) ? ! empty($this->development) : ! empty($this->development[$group]);
    }

    /**
     * Reset the development assets.
     * 
     * @param  string  $group
     * @return void
     */
    public function resetDevelopmentAssets($group = null)
    {
        if (is_null($group))
        {
            $this->development = array();
        }
        else
        {
            $this->development[$group] = array();
        }
    }

    /**
     * Set the entry fingerprint.
     *
     * @param  string  $group
     * @param  string  $fingerprint
     * @return void
     */
    public function setProductionFingerprint($group, $fingerprint)
    {
        $this->fingerprints[$group] = $fingerprint;
    }

    /**
     * Determine if entry has a fingerprint.
     *
     * @param  string  $group
     * @return bool
     */
    public function hasProductionFingerprint($group)
    {
        return ! is_null($this->getProductionFingerprint($group));
    }

    /**
     * Determine if entry has any fingerprints.
     * 
     * @return bool
     */
    public function hasProductionFingerprints()
    {
        return $this->hasProductionFingerprint('stylesheets') or $this->hasProductionFingerprint('javascripts');
    }

    /**
     * Get the entry fingerprint.
     *
     * @param  string  $group
     * @return string|null
     */
    public function getProductionFingerprint($group)
    {
        return isset($this->fingerprints[$group]) ? $this->fingerprints[$group] : null;
    }

    /**
     * Get all entry fingerprints.
     *
     * @return array
     */
    public function getProductionFingerprints()
    {
        return $this->fingerprints;
    }

    /**
     * Reset a production fingerprint.
     * 
     * @param  string  $group
     * @return void
     */
    public function resetProductionFingerprint($group)
    {
        $this->fingerprints[$group] = null;
    }

    /**
     * Reset all production fingerprints.
     * 
     * @return void
     */
    public function resetProductionFingerprints()
    {
        $this->fingerprints = array();
    }

    /**
     * Convert the entry to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Convert the entry to its array representation.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

}