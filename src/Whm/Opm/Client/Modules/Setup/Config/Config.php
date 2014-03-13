<?php
namespace Whm\Opm\Client\Modules\Setup\Config;

use Whm\Opm\Client\Modules\Setup\Config\Command\SetupConfig;

use Symfony\Component\Console\Application;

class Config
{

    /**
     * @Event("client.application.init")
     */
    public function registerCommand (Application $application)
    {
        $application->add(new SetupConfig());
    }
}