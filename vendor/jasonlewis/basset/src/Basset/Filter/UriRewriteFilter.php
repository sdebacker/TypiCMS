<?php namespace Basset\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

/**
 * UriRewriteFilter is a rewrite and port of the popular CssUriRewrite class written by Steve Clay.
 * Original source can be found by following the links below.
 *
 * @author    Steve Clay
 * @link      <https://github.com/mrclay/minify>
 * @license   <https://github.com/mrclay/minify/blob/master/LICENSE.txt>
 * @package   Minify
 * @copyright 2008 Steve Clay / Ryan Grove
 */
class UriRewriteFilter implements FilterInterface {

    /**
     * Applications document root. This is typically the public directory.
     *
     * @var string
     */
    protected $documentRoot;

    /**
     * Root directory of the asset.
     *
     * @var string
     */
    protected $assetDirectory;

    /**
     * Array of symbolic links.
     *
     * @var array
     */
    protected $symlinks;

    /**
     * Create a new UriRewriteFilter instance.
     *
     * @param  string  $documentRoot
     * @param  array  $symlinks
     * @return void
     */
    public function __construct($documentRoot = null, $symlinks = array())
    {
        $this->documentRoot = $this->realPath($documentRoot ?: $_SERVER['DOCUMENT_ROOT']);
        $this->symlinks = $symlinks;
    }

    /**
     * Apply filter on file load.
     *
     * @param  \Assetic\Asset\AssetInterface  $asset
     * @return void
     */
    public function filterLoad(AssetInterface $asset){}

    /**
     * Apply a filter on file dump.
     *
     * @param  \Assetic\Asset\AssetInterface  $asset
     * @return void
     */
    public function filterDump(AssetInterface $asset)
    {
        $this->assetDirectory = $this->realPath($asset->getSourceRoot());

        $content = $asset->getContent();

        // Spin through the symlinks and normalize them. We'll first unset the original
        // symlink so that it doesn't clash with the new symlinks once they are added
        // back in.
        foreach ($this->symlinks as $link => $target)
        {
            unset($this->symlinks[$link]);

            if ($link == '//')
            {
                $link = $this->documentRoot;
            }
            else
            {
                $link = str_replace('//', $this->documentRoot.'/', $link);
            }

            $link = strtr($link, '/', DIRECTORY_SEPARATOR);

            $this->symlinks[$link] = $this->realPath($target);
        }

        $content = $this->trimUrls($content);

        $content = preg_replace_callback('/@import\\s+([\'"])(.*?)[\'"]/', array($this, 'processUriCallback'), $content);

        $content = preg_replace_callback('/url\\(\\s*([^\\)\\s]+)\\s*\\)/', array($this, 'processUriCallback'), $content);

        $asset->setContent($content);
    }

    /**
     * Takes a path and transforms it to a real path.
     *
     * @param  string  $path
     * @return string
     */
    protected function realPath($path)
    {
        if ($realPath = realpath($path))
        {
            $path = $realPath;
        }

        return rtrim($path, '/\\');
    }

    /**
     * Trims URLs.
     *
     * @param  string  $content
     * @return string
     */
    protected function trimUrls($content)
    {
        return preg_replace('/url\\(\\s*([^\\)]+?)\\s*\\)/x', 'url($1)', $content);
    }

    /**
     * Processes a regular expression callback, determines the URI and returns the rewritten URIs.
     *
     * @param  array  $matches
     * @return string
     */
    protected function processUriCallback($matches)
    {
        $isImport = $matches[0][0] === '@';

        // Determine what the quote character and the URI is, if there is one.
        $quoteCharacter = $uri = null;

        if ($isImport)
        {
            $quoteCharater = $matches[1];

            $uri = $matches[2];
        }
        else
        {
            if ($matches[1][0] === "'" or $matches[1][0] === '"')
            {
                $quoteCharacter = $matches[1][0];
            }

            if ( ! $quoteCharacter)
            {
                $uri = $matches[1];
            }
            else
            {
                $uri = substr($matches[1], 1, strlen($matches[1]) - 2);
            }
        }

        // Analyze the URI
        if ($uri[0] !== '/' and strpos($uri, '//') === false and strpos($uri, 'data') !== 0)
        {
            $uri = $this->rewriteRelative($uri);
        }

        if ($isImport)
        {
            return "@import {$quoteCharacter}{$uri}{$quoteCharacter}";
        }

        return "url({$quoteCharacter}{$uri}{$quoteCharacter})";
    }

    /**
     * Rewrites a relative URI.
     *
     * @param  string  $uri
     * @return string
     */
    protected function rewriteRelative($uri)
    {
        $path = strtr($this->assetDirectory, '/', DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.strtr($uri, '/', DIRECTORY_SEPARATOR);

        foreach ($this->symlinks as $link => $target)
        {
            if (strpos($path, $target) === 0)
            {
                $path = $link.substr($path, strlen($target));

                break;
            }
        }

        // Strip the document root from the path.
        $path = substr($path, strlen($this->documentRoot));

        $uri = strtr($path, '/\\', '//');
        $uri = $this->removeDots($uri);

        return $uri;
    }

    /**
     * Removes dots from a URI.
     *
     * @param  string  $uri
     * @return string
     */
    protected function removeDots($uri)
    {
        $uri = str_replace('/./', '/', $uri);

        do
        {
            $uri = preg_replace('@/[^/]+/\\.\\./@', '/', $uri, 1, $changed);
        }
        while ($changed);

        return $uri;
    }

}