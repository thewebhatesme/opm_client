<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\System;

/**
 * Information test
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
class InformationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Information
     */
    protected $object;

    public function configurationProvider()
    {
        return array(
            array(0, 0, 0),
            array(0, 1, 1),
            array(1, 0, 1),
            array(1, 1, 3)
        );
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Information;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers Whm\Opm\Client\System\Information::getPhpBin
     * @todo   Implement testGetPhpBin().
     */
    public function testGetPhpBin()
    {
        $this->assertEquals(
                PHP_BINARY, '/usr/bin/php5'
        );
    }

}
