<?php

namespace Whm\Opm\Client\Test\Integration;

use Whm\Opm\Client\Modules\ModuleHandler;

use Symfony\Component\Console\Input\InputOption;
use phmLabs\Components\Annovent\Dispatcher;
use Whm\Opm\Client\Console\Application;

abstract class CommandTest extends \PHPUnit_Framework_TestCase
{
    protected function getApplication( )
    {
        $application = new Application();
        $dispatcher = new Dispatcher();

        $dispatcher->connectListeners(ModuleHandler::getModules());

        $application->setEventDispatcher($dispatcher);
        $application->addStandardOption('config', null, InputOption::VALUE_OPTIONAL, '', __DIR__.'/fixtures/config.yml');
        $application->addStandardOption('dryrun', null, InputOption::VALUE_NONE);

        return $application;
    }
}