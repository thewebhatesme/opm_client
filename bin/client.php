#!/usr/bin/env php
<?php
use phmLabs\Components\Annovent\Dispatcher;
use phmLabs\Components\Annovent\Event\Event;
use Symfony\Component\Console\Application;

if (! file_exists(__DIR__ . "/../vendor/autoload.php")) {
    die("\n    You have to run 'composer.phar install' before you can use the client.\n\n");
}

include_once __DIR__ . '/../vendor/autoload.php';

$modules = array("Whm\Opm\Client\Modules\Client\Client",
                 "Whm\Opm\Client\Modules\Messure\HttpArchive\HttpArchive",
                 "Whm\Opm\Client\Modules\Setup\PhantomJS\PhantomJS",
                 "Whm\Opm\Client\Modules\Setup\Config\Config");

function doctrineloader ($class)
{
    if (file_exists(__DIR__ . "/../src/" . str_replace("\\", DIRECTORY_SEPARATOR, $class).".php")) {
        include_once __DIR__ . "/../src/" . str_replace("\\", DIRECTORY_SEPARATOR, $class).".php";
    }
}
spl_autoload_register("doctrineloader");

$eventDispatcher = new Dispatcher();

foreach ($modules as $module) {
    $moduleObject = new $module();
    $eventDispatcher->connectListener($moduleObject);
}

$eventDispatcher->notify(new Event('client.dispatcher.init', array("dispatcher" => $eventDispatcher)));

$application = new Application();
$eventDispatcher->notify(new Event('client.application.init', array("application" => $application)));

$application->run();