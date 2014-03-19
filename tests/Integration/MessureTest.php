<?php
namespace Whm\Opm\Client\Test\Integration;

use Whm\Opm\Client\Command\Messure;
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

    public function testMessureCommand ()
    {
        $application = $this->getApplication();
        $application->add(new Messure());
        $command = $application->find('messure');
        $commandTester = new CommandTester($command);

        // @todo test used phpunit as script for messurement
        $commandTester->execute(array('command' => $command->getName(),'--dryrun' => true, 'identifier' => "id1", "messureType" => "Opm:HttpArchive", "parameters" => 'a:1:{s:3:"url";s:20:"http://www.google.de";}'));

        $result = $commandTester->getDisplay(true);

        $expectedOutput[] = "Identifier: id1";
        $expectedOutput[] = "Result:";
        $expectedOutput[] = '"version": "1.2",';
        $expectedOutput[] = '"name": "PhantomJS"';
        $expectedOutput[] = '"id": "http://www.google.de"';
        $expectedOutput[] = '"url": "http://ssl.gstatic.com/gb/images/b_8d5afc09.png",';

        foreach ($expectedOutput as $line) {
            $pos = strpos($result, $line);
            if ($pos === false) {
                $this->assertTrue(false, "Command output does not match expected output. \nExpected: ". $line);
            }
        }
    }
}