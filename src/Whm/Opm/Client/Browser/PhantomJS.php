<?php

namespace Whm\Opm\Client\Browser;

use Whm\Opm\Client\Browser\Browser;

class PhantomJS implements Browser
{

    /**
     * Path to the phantomJS executable
     * @var string
     */
    private $phantomExecutable;

    /**
     * Path to the netSniffing phantomJS script
     * @var string
     */
    private $netsniffScript;

    /**
     * Initialize a phantomjs object
     *
     * @param null $phantomPath
     */
    public function __construct ($phantomPath = null)
    {
        $this->phantomExecutable = $phantomPath;
        $this->netsniffScript = $phantomPath . '/examples/netsniff.js';
    }

    /**
     * Execute the phantomjs netsniffing script for a given URI
     *
     * @param array $parameters
     * @return string
     */
    private function execute (array $parameters)
    {
        $cmd = $this->phantomExecutable . ' ' . implode($parameters, ' ');
        return shell_exec($cmd);
    }

    /**
     * Create HAR archive from the sniffing result and return it.
     *
     * @param $url
     * @return string
     */
    public function createHttpArchive ($url)
    {
        $httpArchive = $this->execute(array(
                $this->netsniffScript,
                $url
        ));

        return $httpArchive;
    }
}
