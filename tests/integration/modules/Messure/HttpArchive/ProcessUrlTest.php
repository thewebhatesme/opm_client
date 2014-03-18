<?php

use Whm\Opm\Client\Modules\Messure\HttpArchive\Command\ProcessUrl;

use Symfony\Component\Console\Application;

use Symfony\Component\Console\Tester\CommandTester;

class ProcessUrlTest extends PHPUnit_Framework_TestCase
{

    public function setUp ()
    {
        $configfile = __DIR__ . "../../../../../config.yml";
        if (! file_exists($configfile)) {
            copy(__DIR__ . "/../../../fixtures/config.yml", $configfile);
        }
    }

    public function testProcessUrl ()
    {
        $application = new Application();
        $application->add(new ProcessUrl());
        $command = $application->find('messure:httpArchive:processUrl');
        $commandTester = new CommandTester($command);

        $commandTester->execute(array('command' => $command->getName(), "config" => "config.yml", "url" => "http://www.google.de"));

        $this->assertTrue(true);
    }
}