<?php

use Whm\Opm\Client\Modules\Client\Command\RunMessurement;

use Symfony\Component\Console\Application;

use Symfony\Component\Console\Tester\CommandTester;

class RunTest extends PHPUnit_Framework_TestCase
{

    public function setUp ()
    {
        $configfile = __DIR__ . "/../../../../config.yml";
        if (! file_exists($configfile)) {
            copy(__DIR__ . "/../../fixtures/config.yml", $configfile);
        }
    }

    public function testRunMessurement ()
    {
        $application = new Application();
        $application->add(new RunMessurement());
        $command = $application->find('run');
        $commandTester = new CommandTester($command);

        $commandTester->execute(array('command' => $command->getName(),"config" => "config.yml"));

        $this->assertTrue(true);
    }
}
