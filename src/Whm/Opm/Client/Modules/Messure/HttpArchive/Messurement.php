<?php

namespace Whm\Opm\Client\Modules\Messure\HttpArchive;

use Whm\Opm\Client\Browser\PhantomJS;

use Whm\Opm\Client\Config\Config;
use Whm\Opm\Client\Messure\Messurement as MessurementInterface;

class Messurement implements MessurementInterface
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
        $phantomJsBin = $this->config->getPhantomJsExecutable();

        if( !is_file($phantomJsBin)) {
            throw new \RuntimeException("PhantomJS binaries not found. Please check your config file or run the setup:phatomjs command.");
        }

        $phantom = new PhantomJS($phantomJsBin);
        $netsniffScript = __DIR__."/CasperJS/netsniff.js";

        return $phantom->execute(array($netsniffScript, $parameters["url"]));
    }
}