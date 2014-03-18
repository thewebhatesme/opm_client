<?php
namespace Whm\Opm\Client\Messure;

use Whm\Opm\Client\Config\Config;

class HttpArchive implements Messurement
{

    private $identifier;

    private $options;

    private $config;

    public function __construct ($identifier, Config $config, array $options)
    {
        $this->config = $config;
        $this->identifier = $identifier;
        $this->options = $options;
    }

    public function getCommand ()
    {
        $command = "php bin/client processUrl " . $this->config->getClientId() . " " . $this->config->getOpmServer() . " " . $this->config->getPhantomExecutable() ." ". $this->options["url"];
        return $command;
    }
}