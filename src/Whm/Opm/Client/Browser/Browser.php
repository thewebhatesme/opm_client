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
 * Interface Browser
 *
 * Interface to define methods for browser adapters such as PhantomJS, SlimerJS or TrifleJS.
 * These are used to collect data on the performance of a website.
 *
 * @category Browser
 * @package  OPMClient
 * @license    https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version   0.0.1
 * @since       2014-01-28
 * @author    Nils Langner <nils.langner@phmlabs.com>
 */
interface Browser
{

    /** Create HAR archive and return it.
     *
     * @link http://www.softwareishard.com/blog/har-12-spec/ HAR archive definition
     * @param $url Address is to be collected by the data
     * @return string HAR archive as JSON object
     */
    public function createHttpArchive($url);

    /**
     * @todo coming soon
     */
    // public function createScreenshot($url);
}
