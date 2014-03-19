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

    /**
     * The opm config file.
     *
     * @var \Whm\Opm\Client\Config\Config
     */
    private $config;

    /**
     * Sets the opm config file.
     *
     * @param \Whm\Opm\Client\Config\Config $config The config file
     *
     * @Event("config.create")
     */
    public function setConfig (Config $config)
    {
        $this->config = $config;
    }

    /**
     * @Event("messure.messurementcontainer.create")
     */
    public function register (MessurementContainer $container)
    {
        $messure = new Messure($this->config);
        $container->addMessurement($messure);
    }
}