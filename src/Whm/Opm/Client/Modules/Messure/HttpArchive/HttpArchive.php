<?php
namespace Whm\Opm\Client\Modules\Messure\HttpArchive;

use Whm\Opm\Client\Modules\Messure\HttpArchive\Messure\HttpArchive as Messure;
use Whm\Opm\Client\Messure\MessurementContainer;
use Whm\Opm\Client\Config\Config;
use Whm\Opm\Client\Messure\Messurement;
use Whm\Opm\Client\Modules\Messure\HttpArchive\Command\ProcessUrl;
use Symfony\Component\Console\Application;

class HttpArchive
{

    private $config;

    /**
     * @Event("client.application.init")
     */
    public function registerCommand (Application $application)
    {
        $application->add(new ProcessUrl());
        var_dump(spl_object_hash($this));
    }

    /**
     * @Event("run.config.create")
     */
    public function setConfig (Config $config)
    {
        $this->config = $config;
    }

    /**
     * @Event("run.messurementcontainer.create")
     */
    public function register (MessurementContainer $container)
    {
        $messure = new Messure($this->config);
        $container->addMessurement($messure);
    }
}