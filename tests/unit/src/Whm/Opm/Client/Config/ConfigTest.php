<?php
/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Config;

use Symfony\Component\Yaml\Exception;

/**
 * Config
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
class ConfigTest extends \PHPUnit_Framework_TestCase
{

    const FIXTURE_PATH = '/../../../../../fixtures/';
    const FIXTURE_FILE_FAIL = 'config_fail.yml';
    const FIXTURE_FILE_EMPTY = 'config_empty.yml';
    const FIXTURE_FILE_SUCCESS = 'config_success.yml';

    /**
     * @var array Holds reference config array 
     */
    private $mockConfigArray;

    /**
     * @var Config
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @dataProvider providerConfig
     */
    protected function setUp()
    {

        $this->mockConfigArray = array(
            'opm-server' =>
            array(
                'host' => 'http://testlab.core'
            ),
            'opm-client' =>
            array(
                'clientid' => 'testid',
                'max-parallel-requests' => 5
            ),
            'phantom' =>
            array(
                'executable' => '/usr/bin/phantomjs'
            ),
        );
        $this->object = new Config($this->mockConfigArray);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testFixtureFileExists()
    {
        $fixtureFileFail = __DIR__ . self::FIXTURE_PATH . self::FIXTURE_FILE_FAIL;
        $this->assertFileExists($fixtureFileFail);
        $fixtureFileEmpty = __DIR__ . self::FIXTURE_PATH . self::FIXTURE_FILE_EMPTY;
        $this->assertFileExists($fixtureFileEmpty);
        $fixtureFileSuccess = __DIR__ . self::FIXTURE_PATH . self::FIXTURE_FILE_EMPTY;
        $this->assertFileExists($fixtureFileSuccess);
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::createFromFile
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $this->object->createFromFile('notAvailable.yml');
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::createFromFile
     * @expectedException Exception
     */
    public function testException()
    {
        $fixtureFileEmpty = __DIR__ . self::FIXTURE_PATH . self::FIXTURE_FILE_FAIL;
        $this->object->createFromFile($fixtureFileEmpty);
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::createFromFile
     * @expectedException Symfony\Component\Yaml\Exception\ParseException
     */
    public function testParseException()
    {
        $fixtureFileFail = __DIR__ . self::FIXTURE_PATH . self::FIXTURE_FILE_FAIL;
        $this->object->createFromFile($fixtureFileFail);
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::createFromFile
     */
    public function testCreateFromFile()
    {
        $this->assertObjectHasAttribute('config', $this->object);
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::getPhantomExecutable
     */
    public function testGetPhantomExecutable()
    {
        $this->assertEquals(
                $this->object->getPhantomExecutable(), $this->mockConfigArray['phantom']['executable']
        );
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::getOpmServer
     */
    public function testGetOpmServer()
    {
        $this->assertEquals(
                $this->object->getOpmServer(), $this->mockConfigArray['opm-server']['host']
        );
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::getClientId
     */
    public function testGetClientId()
    {
        $this->assertEquals(
                $this->object->getClientId(), $this->mockConfigArray['opm-client']['clientid']
        );
    }

    /**
     * @covers Whm\Opm\Client\Config\Config::getMaxParallelRequests
     */
    public function testGetMaxParallelRequests()
    {
        $this->assertEquals(
                $this->object->getMaxParallelRequests(), $this->mockConfigArray['opm-client']['max-parallel-requests']
        );
    }

}
