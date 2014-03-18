<?php

namespace Whm\Opm\Client\Console;

use phmLabs\Components\Annovent\Dispatcher;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

abstract class Command extends SymfonyCommand
{

    private $dispatcher;

    public function setDispatcher (Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    protected function getDispatcher ()
    {}
}