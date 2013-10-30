<?php namespace Basset\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\BaseNodeFilter;
use Assetic\Exception\FilterException;

class CssoFilter extends BaseNodeFilter {

    /**
     * Path to CSSO bin.
     *
     * @var string
     */
    protected $cssoBin;

    /**
     * Path to Node bin.
     *
     * @var string
     */
    protected $nodeBin;

    /**
     * Create a new csso filter instance.
     *
     * @param  string  $cssoBin
     * @param  string  $nodeBin
     * @return void
     */
    public function __construct($cssoBin = '/usr/bin/csso', $nodeBin = null)
    {
        $this->cssoBin = $cssoBin;
        $this->nodeBin = $nodeBin;
    }

    /**
     * Apply filter on file load.
     *
     * @param  \Assetic\Asset\AssetInterface  $asset
     * @return void
     */
    public function filterLoad(AssetInterface $asset)
    {
        $inputFile = tempnam(sys_get_temp_dir(), 'csso');

        file_put_contents($inputFile, $asset->getContent());

        // Before we create our process builder we'll create the arguments to be given to the builder.
        // If we have a node bin supplied then we'll shift that to the beginning of the array.
        $builderArguments = array($this->cssoBin);

        if ( ! is_null($this->nodeBin))
        {
            array_unshift($builderArguments, $this->nodeBin);
        }

        $builder = $this->createProcessBuilder($builderArguments);

        $builder->add($inputFile);

        // Get the process from the builder and run the process.
        $process = $builder->getProcess();

        $code = $process->run();

        unlink($inputFile);

        if ($code !== 0)
        {
            throw FilterException::fromProcess($process)->setInput($asset->getContent());
        }

        $asset->setContent($process->getOutput());
    }

    /**
     * Apply a filter on file dump.
     *
     * @param  \Assetic\Asset\AssetInterface  $asset
     * @return void
     */
    public function filterDump(AssetInterface $asset){}

}