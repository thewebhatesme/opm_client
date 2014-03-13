<?php
use Whm\Opm\Client\Console\Application;

use Symfony\Component\Console\Input\InputOption;

use Whm\Opm\Client\Modules\ModuleHandler;

use phmLabs\Components\Annovent\Event\Event;
use phmLabs\Components\Annovent\Dispatcher;

use Whm\Opm\Client\Command\Messure;
use Whm\Opm\Client\Command\Run;

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
$application->addStandardOption('config', null, InputOption::VALUE_OPTIONAL, '', 'config.yml');

$dispatcher->notify(new Event('kipimoo.client.application.create', array("application" => $application)));

$application->add(new Run());
$application->add(new Messure());

$application->run();