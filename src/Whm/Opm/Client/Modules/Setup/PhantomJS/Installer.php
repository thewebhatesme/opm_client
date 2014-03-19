<?php
/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Modules\Setup\PhantomJS;

use PhantomInstaller\Installer;

/**
 * Class PhantomJSInstaller
 *
 * Static functional class with different methos to load the phantomjs
 * executable to the project directory.
 *
 * @category Installer
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  0.0.1
 * @since    2014-01-28
 * @author   Philipp Bräutigam <philipp.braeutigam@googlemail.com>
 */
class Installer extends Installer
{
    /**
     * Download the archive and extract it to the defined folder
     * @param $downloadPath
     * @return bool
     * @throws \Exception
     */
    public static function downloadArchive($downloadPath)
    {
        if(!is_dir('./install')) {
            mkdir('./install', 0777);
        }

        // Download the phantomJS binary
        $phantomArchive = substr(strrchr($downloadPath, '/'), 1);
        if(!file_exists('.' . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . $phantomArchive)) {
            if(!file_put_contents('.' . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . $phantomArchive, file_get_contents($downloadPath))) {
                throw new \Exception('There was a problem due download the phantomJS binary. Please try again later.');
            }
        }

        return true;
    }

    /**
     * Extract the archive depend on the OS system
     * and move it to the defined folder.
     * @param $downloadPath
     * @param $installDir
     * @throws \Exception
     * @return true;
     */
    public static function extractArchive($downloadPath, $installDir)
    {
        $phantomArchive = substr(strrchr($downloadPath, '/'), 1);

        // Extracting the archive
        switch(self::getOS()) {
            case 'linux':
                shell_exec('tar xfvj .' . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . $phantomArchive . ' -C .' . DIRECTORY_SEPARATOR . 'install');
                break;

            default:
                shell_exec('unzip ' . $phantomArchive . ' -d ' . DIRECTORY_SEPARATOR . 'install');
                break;
        }

        // Move the files to the defined installation directory
        $unusedFileExtensions = array('.zip', '.tar', '.bz2');
        $fileName = str_replace($unusedFileExtensions, '', $phantomArchive);
        if(!rename('.' . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . $fileName . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phantomjs',
                    './bin/phantomjs')) {
            throw new \Exception('Installation of the phantomjs binary failed.');
        }

        if(!rename('.' . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . $fileName . DIRECTORY_SEPARATOR . 'examples',
                './examples')) {
            throw new \Exception('Installation of the phantomjs netsniff.js script failed.');
        }

        return true;
    }

    /**
     * Remove the install folder after downloading
     * and installing the phantomjs library.
     * @return true;
     */
    public static function cleanup()
    {
        shell_exec('rm -rf ./install');
        return true;
    }

}
