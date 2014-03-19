<?php
namespace Whm\Opm\Client\Server;

use Buzz\Browser;
use Whm\Opm\Client\Config\Config;

class Server
{

    private $host;

    private $clientId;

    private $browser;

    private $config;

    public function __construct (Config $config, Browser $browser)
    {
        $this->config = $config;
        $this->host = $this->config->getOpmServer();
        $this->clientId = $this->config->getClientId();
        $this->browser = $browser;
    }

    /**
     * @return \Whm\Opm\Client\Server\MessurementJob
     */
    public function getMessurementJob ()
    {
        $messurementJob = new MessurementJob();

        $messurementJob->addTask('1id', 'Opm:HttpArchive', Array('url' => 'http://www.google.de'));
        $messurementJob->addTask('2id', 'Opm:HttpArchive', Array('url' => 'http://www.yahoo.com'));

        return $messurementJob;
    }

    public function addTaskMessurement ($identifier, $result)
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