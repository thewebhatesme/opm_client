<?php

namespace Whm\Opm\Client\Modules\Messure\HttpArchive;

use Whm\Opm\Client\Messure\MessurementContainer;
use Whm\Opm\Client\Config\Config;

class Listener
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
     * @todo
     * @Event("config.create")
     */
    public function setConfig (Config $config)
    {
        $this->config = $config;
    }

    /**
     * This function is used to make register this messurement module.
     * When registered it can be used on the command line.
     *
     * @Event("messure.messurementcontainer.create")
     */
    public function register (MessurementContainer $container)
    {
        $messure = new Messurement($this->config);
        $container->addMessurement($messure);
    }
}