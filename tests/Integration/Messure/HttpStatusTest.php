<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Test\Integration\Messure;

use Whm\Opm\Client\Test\Integration\CommandTest;
use Whm\Opm\Client\Command\Messure;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * HttpStatus test
 *
 * @category Test
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  GIT: $Id$
 */
class HttpStatusTest extends CommandTest
{

    public function testMessureCommand()
    {
        $application = $this->getApplication();
        $application->add(new Messure());
        $command = $application->find('messure');
        $commandTester = new CommandTester($command);

        $commandTester->execute(array(
            'command' => $command->getName(),
            '--dryrun' => true,
            'identifier' => 'id1',
            'messureType' => 'Opm:HttpStatusOk',
            "parameters" => 'a:1:{s:3:"url";s:20:"http://www.google.de";}'
                )
        );

        $result = $commandTester->getDisplay(true);

        $expectedOutput[] = 'Identifier: id1';
        $expectedOutput[] = 'Result: 1';

        foreach ($expectedOutput as $line) {
            $pos = strpos($result, $line);
            if ($pos === false) {
                $this->assertTrue(false, "Command output does not match expected outut.\nExpected: " . $line . "\nCurrent: " . $result);
            }
        }
    }

}
