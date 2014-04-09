<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Browser;

/**
 * PhantomJS test
 *
 * To handle and load configurations from yaml files.
 *
 * @category Test
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  GIT: $Id$
 * @since    Date: 2014-03-22
 * @author   André Lademann <andre.lademann@programmerq.eu>
 */
class PhantomJSTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PhantomJS
     */
    protected $object;

    public function parameterProvider()
    {
        return array(
            array(array('test', 'this', 'params')),
        );
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new PhantomJS('./bin/phantomjs');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers \Whm\Opm\Client\Browser\PhantomJS::getExecuteString
     * @dataProvider parameterProvider
     */
    public function testGetExecuteString($parameters)
    {
        // Make private methode readable
        $reflection_class = new \ReflectionClass('Whm\Opm\Client\Browser\PhantomJS');
        $method = $reflection_class->getMethod("getExecuteString");
        $method->setAccessible(true);

        // assertions
        $this->assertEquals(
                $method->invoke($this->object, $parameters), './bin/phantomjs test this params');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExcecuteException()
    {
        $object = new PhantomJS('notExtistCommand');
        $parameters = array('optional', 'parameter');
        $object->execute($parameters);
    }

    /**
     * @covers \Whm\Opm\Client\Browser\PhantomJS::execute
     */
    public function testExecute()
    {
        $object = new PhantomJS('phantomjs');
        $this->assertNotNull($object->execute(array('--version')));
    }

}
