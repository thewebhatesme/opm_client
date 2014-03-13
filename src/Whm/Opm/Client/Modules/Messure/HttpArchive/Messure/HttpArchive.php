<?php

namespace Whm\Opm\Client\Modules\Messure\HttpArchive\Messure;

use Whm\Opm\Client\Browser\PhantomJS;

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
        $phantom = new PhantomJS($this->config->getPhantomExecutable());
        $netsniffScript = __DIR__."/../CasperJS/netsniff.js";

        return $phantom->execute(array($netsniffScript, $parameters["url"]));
    }
}