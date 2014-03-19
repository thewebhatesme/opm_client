<?php
namespace Whm\Opm\Client\Test\Integration;

use Whm\Opm\Client\Command\Run;
use Symfony\Component\Console\Tester\CommandTester;

class RunTest extends CommandTest
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
        $commandTester->execute(array('command' => $command->getName(),'--dryrun' => true));

        $expectedOutput[] = "Executing Command: /usr/bin/php /var/www/opm/src/Whm/Opm/Client/Command/../../../../../bin/client.php messure 1id Opm:HttpArchive 'a:1:{s:3:\"url\";s:20:\"http://www.google.de\";}' --config config.yml\n";
        $expectedOutput[] = "Executing Command: /usr/bin/php /var/www/opm/src/Whm/Opm/Client/Command/../../../../../bin/client.php messure 2id Opm:HttpArchive 'a:1:{s:3:\"url\";s:20:\"http://www.yahoo.com\";}' --config config.yml";

        $result = $commandTester->getDisplay(true);

        foreach ($expectedOutput as $line) {
            $pos = strpos($result, $line);
            if ($pos === false) {
                $this->assertTrue(false, "Command output does not match expected outut.\nExpected: ". $line);
            }
        }
    }
}