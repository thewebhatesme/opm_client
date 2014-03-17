<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */
namespace Whm\Opm\Client\Browser;

/**
 * Class PhantomJS
 *
 * Uses the headless WebKit browser *PhantomJS* to collect data on the performance of a website.
 *
 * @category Browser
 * @package OPMClient
 * @license https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @example $./bin/client setup:phantomjs
 * @version GIT: $Id$
 * @since Date: 2014-01-28
 * @author Nils Langner <nils.langner@phmlabs.com>
 * @link http://phantomjs.org/network-monitoring.html PhantomJS network monitoring documentation
 */
class PhantomJS implements Browser
{

    /**
     * Path to the PhantomJS executable
     *
     * @var string
     */
    private $phantomJsExecutable;

    /**
     * Path to the netSniffing PhantomJS script
     *
     * @var string
     */
    private $netsniffScript;

    /**
     * Initialize a PhantomJS object
     *
     * @param string $phantomJsPath path tp to *PhantomJS* executeable binary
     * @return void
     */
    public function __construct ($phantomJsPath = null)
    {
        $this->phantomJsExecutable = $phantomJsPath . 'bin/phantomjs';
        $this->netsniffScript = $phantomJsPath . 'examples/netsniff.js';
    }

    /**
     * Execute the PhantomJS netsniffing script for a given URI
     *
     * @param array $parameters for PhantomJS
     * @return string shell command
     */
    private function execute (array $parameters)
    {
        $cmd = $this->phantomJsExecutable . ' ' . implode($parameters, ' ');

        return shell_exec($cmd);
    }

    /**
     * Create HAR archive from the sniffing result and return it.
     *
     * @link https://github.com/ariya/phantomjs/blob/master/examples/netsniff.js Netsniff script
     * @link http://phantomjs.org/network-monitoring.html Introduction in network monitoring with PhantomJS
     * @link http://www.softwareishard.com/blog/har-12-spec/ HAR archive definition
     * @param string $url Address is to be collected by the data
     * @return string HAR archive as JSON object
     */
    public function createHttpArchive ($url)
    {
        $httpArchive = $this->execute(array ($this->netsniffScript, $url));

        return $httpArchive;
    }
}
