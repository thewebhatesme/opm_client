<?php

namespace Whm\Opm\Client\Test\Integration;

use Whm\Opm\Client\Command\Run;
use Symfony\Component\Console\Tester\CommandTester;

class MessureTest extends CommandTest
{

    public function setUp ()
    {
        $configfile = __DIR__ . "/../../config.yml";
        if (! file_exists($configfile)) {
            copy(__DIR__ . "/fixtures/config.yml", $configfile);
        }
    }

    public function testRunCommand ()
    {
        $application = $this->getApplication();
        $application->add(new Run());
        $command = $application->find('run');
        $commandTester = new CommandTester($command);

        // @todo test used phpunit as script for messurement
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertTrue(true);
    }
}