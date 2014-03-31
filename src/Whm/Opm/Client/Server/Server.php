<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Server;

use Buzz\Browser;
use Whm\Opm\Client\Config\Config;

/**
 * Server
 *
 * @category Server
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  GIT: $Id$
 * @since    Date: 2014-03-24
 * @author   André Lademann <andre.lademann@programmerq.eu>
 */
class Server
{

    /**
     * @var type
     */
    private $host;

    /**
     * @var type
     */
    private $clientId;

    /**
     * @var type
     */
    private $browser;

    /**
     * @var type
     */
    private $config;

    /**
     *
     * @param \Whm\Opm\Client\Config\Config $config
     * @param \Buzz\Browser $browser
     */
    public function __construct(Config $config, Browser $browser)
    {
        $this->config = $config;
        $this->host = $this->config->getOpmServer();
        $this->clientId = $this->config->getClientId();
        $this->browser = $browser;
    }

    /**
     * @return \Whm\Opm\Client\Server\MessurementJob
     */
    public function getMessurementJob()
    {
        $messurementJob = new MessurementJob();

        $messurementJob->addTask('1id', 'Opm:HttpArchive', array('url' => 'http://www.google.de'));
        $messurementJob->addTask('2id', 'Opm:HttpArchive', array('url' => 'http://www.yahoo.com'));

        return $messurementJob;
    }

    /**
     *
     * @param type $identifier
     * @param type $result
     * @throws \DomainException
     */
    public function addTaskMessurement($identifier, $result)
    {
        $browser = $this->browser;

        $restApi = $this->host . '/add/' . $this->clientId . '/' . $identifier . '/';

        $response = $browser->post($restApi, array(), $result);
        // $response = $browser->post($restApi, array(), ($httpArchive));

        if ($response->getStatusCode() != '200') {
            throw new \DomainException('Couldn\'t connect to server (url: ' . $restApi . ' | ' . $response->getStatusCode() . ' - ' . $response->getReasonPhrase() . ')');
        }
    }

}
