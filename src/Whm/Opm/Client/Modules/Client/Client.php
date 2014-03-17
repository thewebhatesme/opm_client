<?php
namespace Whm\Opm\Client\Modules\Client;

use phmLabs\Components\Annovent\Dispatcher;
use Whm\Opm\Client\Modules\Client\Command\RunMessurement;
use Symfony\Component\Console\Application;

class Client
{

    private $dispatcher;

    /**
     * @Event("client.application.init")
     */
    public function registerCommand (Application $application)
    {
        $command = new RunMessurement();
        $command->setDispatcher($this->dispatcher);
        $application->add($command);
    }

    /**
     * @Event("client.dispatcher.init")
     */
    public function setEventDispatcher (Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}