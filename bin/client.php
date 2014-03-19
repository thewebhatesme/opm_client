<?php

use Whm\Opm\Client\Command\Messure;
use Whm\Opm\Client\Command\Run;
use Whm\Opm\Client\Console\Application;
use Whm\Opm\Client\Modules\ModuleHandler;

use Symfony\Component\Console\Input\InputOption;

use phmLabs\Components\Annovent\Event\Event;
use phmLabs\Components\Annovent\Dispatcher;

// @todo this should be part of the composer.json file
$loader = include_once __DIR__ . "/../vendor/autoload.php";
$loader->add("phmLabs", __DIR__ . "/../src/");
$loader->add("Doctrine", __DIR__ . "/../src/");
$loader->add("Whm", __DIR__ . "/../src/");

// create the event dispatcher
$dispatcher = new Dispatcher();

// register modules
$dispatcher->connectListeners(ModuleHandler::getModules());

// create the application
$application = new Application();
$application->setEventDispatcher($dispatcher);
$application->addStandardOption('config', null, InputOption::VALUE_OPTIONAL, 'The config file.', 'config.yml');
$application->addStandardOption('dryrun', null, InputOption::VALUE_NONE, 'If set the run will not send data to the server.');

$dispatcher->notify(new Event('kipimoo.client.application.create', array("application" => $application)));

// add the default commands
$application->add(new Run());
$application->add(new Messure());

// run the application
$application->run();