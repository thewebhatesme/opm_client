<?php

namespace Whm\Opm\Client\Modules\Setup\PhantomJS;

use Whm\Opm\Client\Modules\Setup\PhantomJS\Command\SetupPhantomJS;
use Whm\Opm\Client\Modules\Setup\Config\Command\SetupConfig;
use Symfony\Component\Console\Application;

class PhantomJS
{

    /**
     * @Event("kipimoo.client.application.create")
     */
    public function registerCommand (Application $application)
    {
        $application->add(new SetupPhantomJS());
    }
}