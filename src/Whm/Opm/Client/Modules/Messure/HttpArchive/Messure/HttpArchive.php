<?php

namespace Whm\Opm\Client\Modules\Messure\HttpArchive\Messure;

use Whm\Opm\Client\Config\Config;
use Whm\Opm\Client\Messure\Messurement;

class HttpArchive implements Messurement
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getType ()
    {
        return "Opm:HttpArchive";
    }

    public function run ($identifier, array $parameters)
    {
        $command = "php bin/client processUrl " . $this->config->getClientId() . " " . $this->config->getOpmServer() . " " . $this->config->getPhantomExecutable() . " " . $this->options["url"];
        echo $command;
        return "some har data";
    }
}