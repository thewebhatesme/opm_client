<?php

namespace Whm\Opm\Client\Modules\Setup\PhantomJs;

use Whm\Opm\Client\Modules\Setup\Config\Command\SetupConfig;
use Symfony\Component\Console\Application;

class Listener
{

    /**
     * @Event("kipimoo.client.application.create")
     */
    public function registerCommand (Application $application)
    {
        $application->add(new Command());
    }
}