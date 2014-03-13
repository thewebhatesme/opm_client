<?php

use Whm\Opm\Client\Command\RunMessurement;

if(!file_exists(__DIR__."/../vendor/autoload.php")) {
   die("\n    You have to run 'composer.phar install' before you can use the client.\n\n");
}

include_once __DIR__.'/../vendor/autoload.php';

use Whm\Opm\Client\Command\ProcessUrl;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new RunMessurement);
$application->add(new ProcessUrl);
$application->run();
