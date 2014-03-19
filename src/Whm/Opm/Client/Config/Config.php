<?php
/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Config;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Config
 *
 * To handle and load configurations from yaml files.
 *
 * @category Config
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  GIT: $Id$
 * @since    Date: 2014-01-28
 * @author   Nils Langner <nils.langner@phmlabs.com>
 * @author   André Lademann <andre.lademann@preogrammerq.eu>
 */
class Config
{

    private $config = array();

    /**
     * Constructor to hold configuration array
     *
     * @param array $configArray
     *
     * @return void
     */
    public function __construct(array $configArray)
    {
        $this->config = $configArray;
    }

    /**
     * Load configuration data in this object
     *
     * @param   string $filePath the yaml file name.
     * @uses    \Symfony\Component\Yaml to parse YAML file and convert in PHP array
    *
     * @return  \Whm\Opm\Client\Config\Config
     * 
     * @throws  \InvalidArgumentException
     * @throws  \ParseException
     */
    public static function createFromFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException('Configuration file was not found.');
        }
        $yaml = new Yaml();

        try {
            $valueArray = $yaml->parse(file_get_contents($filePath));
        } catch (ParseException $e) {
            throw $e;
        }

        return new self($valueArray);
    }

    /**
     * @return string path to PhantomJS binary
     */
    public function getPhantomExecutable()
    {
        return $this->config['phantom']['executable'];
    }

    /**
     * @return string Host of the Open Performance Monitor server
     */
    public function getOpmServer()
    {
        return $this->config['opm-server']['host'];
    }

    /**
     * @return string The user ID of the client, with which he is registered with the server.
     */
    public function getClientId()
    {
        return $this->config['opm-client']['clientid'];
    }

    /**
     * @return int The maximum number of simultaneous client requestst.
     */
    public function getMaxParallelRequests()
    {
        return (int) $this->config['opm-client']['max-parallel-requests'];
    }

}
