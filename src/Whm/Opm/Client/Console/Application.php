<?php

namespace Whm\Opm\Client\Console;

use Symfony\Component\Console\Command\Command;

use phmLabs\Components\Annovent\Dispatcher;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{

    private $standardOptions = array ();

    private $dispatcher;

    public function setDispatcher (Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function addStandardOption ($name, $shortcut = null, $mode = null, $description = '', $default = null)
    {
        $this->standardOptions[$name] = array ("shortcut" => $shortcut, "mode" => $mode, "description" => $description, "default" => $default);
    }

    public function add (Command $command)
    {
        if ($command instanceof \Whm\Opm\Client\Console\Command) {
            $command->setDispatcher($this->dispatcher);
        }

        foreach ($this->standardOptions as $name => $params) {
            $command->addOption($name, $params['shortcut'], $params["mode"], $params["description"], $params["default"]);
        }

        parent::add($command);
    }
}
