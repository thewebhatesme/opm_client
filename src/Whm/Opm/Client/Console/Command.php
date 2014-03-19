<?php
namespace Whm\Opm\Client\Console;

use phmLabs\Components\Annovent\Dispatcher;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

abstract class Command extends SymfonyCommand
{

    private $dispatcher;

    public function setEventDispatcher (Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     *
     * @return Dispatcher
     */
    protected function getEventDispatcher ()
    {
        return $this->dispatcher;
    }
}