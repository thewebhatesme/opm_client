<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Server;

/**
 * MessurementJobServer test
 *
 *
 * @category Test
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  GIT: $Id$
 * @since    Date: 2014-03-24
 * @author   Nils Langner <nils.langner@phmlabs.com>
 */
class MessurementJob
{

    private $tasks = array();

    /**
     * addTask
     *
     * @param string    $identifier
     * @param string    $type
     * @param array     $parameters
     */
    public function addTask($identifier, $type, array $parameters)
    {
        $this->tasks[$identifier] = array("type" => $type, "parameters" => serialize($parameters));
    }

    /**
     * @return array Array contains tasks
     */
    public function getTasks()
    {
        return $this->tasks;
    }

}
