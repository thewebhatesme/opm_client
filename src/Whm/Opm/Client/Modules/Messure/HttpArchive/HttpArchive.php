<?php
namespace Whm\Opm\Client\Modules\Messure\HttpArchive;

use Whm\Opm\Client\Modules\Messure\HttpArchive\Command\ProcessUrl;

use Symfony\Component\Console\Application;

class HttpArchive
{

    /**
     * @Event("client.application.init")
     */
    public function registerCommand (Application $application)
    {
        $application->add(new ProcessUrl());
    }
}