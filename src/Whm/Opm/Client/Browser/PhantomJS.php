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
 * @category    Browser
 * @package     OPMClient
 * @license     https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @example     $./bin/client setup:phantomjs
 * @version     GIT: $Id$
 * @since       Date: 2014-01-28
 * @author      Nils Langner <nils.langner@phmlabs.com>
 * @link        http://phantomjs.org/network-monitoring.html PhantomJS network monitoring documentation
 */
class PhantomJS
{

    /**
     * Path to the PhantomJS executable
     *
     * @var string
     */
    private $phantomJsExecutable;

    /**
     * Initialize a PhantomJS object
     *
     * @param string $phantomJsExecPath path tp to *PhantomJS* executeable binary
     */
    public function __construct ($phantomJsExecPath = null)
    {
        $this->phantomJsExecutable = $phantomJsExecPath;
    }

    /**
     * Execute the PhantomJS netsniffing script for a given URI
     *
     * @param   array   $parameters for PhantomJS
     *
     * @return  string  shell command
     */
    public function execute (array $parameters)
    {
        $cmd = $this->phantomJsExecutable . ' ' . implode($parameters, ' ');
        return shell_exec($cmd);
    }
}