<?php namespace Thomaswelton\LaravelGravatar;

use \Config;
use Illuminate\Support\Facades\HTML;

class Gravatar extends \emberlabs\gravatarlib\Gravatar
{
    private $default_size = null;

    public function __construct()
    {
        // Enable secure images by default

        $this->setDefaultImage(Config::get('laravel-gravatar::default'));
        $this->default_size = Config::get('laravel-gravatar::size');

        $this->setMaxRating(Config::get('laravel-gravatar::maxRating', 'g'));
        $this->enableSecureImages();
    }

    public function src($email, $size = null, $rating = null)
    {
        if (is_null($size)) {
            $size = $this->default_size;
        }

        $size = max(1, min(512, $size));

        $this->setAvatarSize($size);

        if(!is_null($rating)) $this->setMaxRating($rating);

        return $this->buildGravatarURL($email);
    }

    public function image($email, $alt = null, $attributes = array(), $rating = null)
    {
        $dimensions = array();

        if(array_key_exists('width', $attributes)) $dimensions[] = $attributes['width'];
        if(array_key_exists('height', $attributes)) $dimensions[] = $attributes['height'];

        $max_dimension = (count($dimensions)) ? min(512, max($dimensions)) : $this->default_size;

        $src = $this->src($email, $max_dimension, $rating);

        if (!array_key_exists('width', $attributes) && !array_key_exists('height', $attributes)) {
            $attributes['width'] = $this->size;
            $attributes['height'] = $this->size;
        }

        return HTML::image($src, $alt, $attributes);
    }
}
