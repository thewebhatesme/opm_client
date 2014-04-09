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
    public function __construct($phantomJsExecPath = null)
    {
        $this->phantomJsExecutable = $phantomJsExecPath;
    }

    /**
     * Build the execute string to run PhantomJS netsniffing script for a given URI
     *
     * @param   array $parameters for PhantomJS
     *
     * @return  string to execute as shell command
     */
    private function getExecuteString(array $parameters)
    {
        return $this->phantomJsExecutable . ' ' . implode($parameters, ' ');
    }

    /**
     * Execute the PhantomJS netsniffing script for a given URI
     *
     * @param array $parameters for PhantomJS
     *
     * @return string The output from the executed command or <b>NULL</b> if an error
     * occurred or the command produces no output.
     * 
     * @throws RuntimeException when safe mod ist enabled
     * @throws InvalidArgumentException when shell command not work
     */
    public function execute(array $parameters)
    {
        $commandString = $this->getExecuteString($parameters);
        if (ini_get('safe_mode')) {
            throw new \RuntimeException('Safe mode is enbled.');
        }

        $responseString = shell_exec($commandString);
        if (is_null($responseString)) {
            throw new \InvalidArgumentException('Error shell execution: ' . $responseString);
        }

        return $responseString;
    }

}
