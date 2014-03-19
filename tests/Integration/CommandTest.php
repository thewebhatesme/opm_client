<?php

namespace Whm\Opm\Client\Test\Integration;

use Symfony\Component\Console\Input\InputOption;
use phmLabs\Components\Annovent\Dispatcher;
use Whm\Opm\Client\Console\Application;

abstract class CommandTest extends \PHPUnit_Framework_TestCase
{
    protected function getApplication( )
    {
        $application = new Application();
        $dispatcher = new Dispatcher();

        $application->setEventDispatcher($dispatcher);
        $application->addStandardOption('config', null, InputOption::VALUE_OPTIONAL, '', 'config.yml');

        return $application;
    }

}