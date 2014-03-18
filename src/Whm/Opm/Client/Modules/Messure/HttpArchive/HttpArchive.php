<?php

namespace Whm\Opm\Client\Modules\Messure\HttpArchive;

use Whm\Opm\Client\Messure\MessurementContainer;

use Whm\Opm\Client\Config\Config;

use Whm\Opm\Client\Messure\Messurement;
use Whm\Opm\Client\Modules\Messure\HttpArchive\Command\ProcessUrl;
use Symfony\Component\Console\Application;

class HttpArchive implements Messurement
{

    private $config;

    /**
     * @Event("client.application.init")
     */
    public function registerCommand (Application $application)
    {
        $application->add(new ProcessUrl());
        var_dump( spl_object_hash($this));
    }

    /**
     * @Event("run.config.create")
     */
    public function setConfig (Config $config)
    {
        echo "hier !!!";
        $this->config = $config;

        var_dump( $this->config );

        var_dump( spl_object_hash($this));
    }

    /**
     * @Event("run.messurementcontainer.create")
     */
    public  function register(MessurementContainer $container)
    {
        $container->addMessurement($this);
    }

    public function getCommand ()
    {
        var_dump($this->config);
        var_dump( spl_object_hash($this));

        $command = "php bin/client processUrl " . $this->config->getClientId() . " " . $this->config->getOpmServer() . " " . $this->config->getPhantomExecutable() . " " . $this->options["url"];
        return $command;
    }
}