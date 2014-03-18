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

    public function __construct (Config $config)
    {
        $this->config = $config;
        $this->host = $this->config->getOpmServer();
        $this->clientId = $this->config->getClientId();
    }

    public function setBrowser (Browser $browser)
    {
        $this->browser = $browser;
    }

    private function getBrowser ()
    {
        if (is_null($this->browser)) {
            $this->browser = new Browser();
        }
        return $this->browser;
    }

    /**
     *
     * @return \Whm\Opm\Client\Server\MessurementJob
     */
    public function getMessurementJob ()
    {
        $messurementJob = new MessurementJob("12:00");

        $messurementJob->addTask(new Task("identifier1", 'Whm\Opm\Client\Messure\HttpArchive', $this->config, Array("url" => "http://www.google.de", "_host" => $this->host, "_clientId" => $this->clientId)));
        $messurementJob->addTask(new Task("identifier2", 'Whm\Opm\Client\Messure\HttpArchive', $this->config, Array("url" => "http://www.thewebhatesme.de", "_host" => $this->host, "_clientId" => $this->clientId)));

        return $messurementJob;
    }

    public function addTaskMessurement ($identifier, $result)
    {
        $browser = $this->getBrowser();

        $restApi = $this->host . '/add/' . $this->clientId . '/' . $identifier . '/';

        $response = $browser->post($restApi, array(), $result);
        // $response = $browser->post($restApi, array(), ($httpArchive));

        if ($response->getStatusCode() != '200') {
            throw new \DomainException("Couldn't connect to server (url: " . $restApi . " | " . $response->getStatusCode() . " - " . $response->getReasonPhrase() . ")");
        }
    }
}