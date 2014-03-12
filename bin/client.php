<?php

include_once __DIR__.'/../vendor/autoload.php';

use Whm\Opm\Client\Command\ProcessUrl;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ProcessUrl);
$application->run();