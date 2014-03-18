<?php
namespace Whm\Opm\Client\Modules\Setup\PhantomJS\Command;

use Composer\Composer;
use Composer\Package\Package;
use Composer\Package\Version\VersionParser;
use PhantomInstaller\Installer;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class SetupPhantomJS extends Command
{
    /**
     * The PhantomJS Version
     */
    const PHANTOMJS_VERSION = '1.9.7';

    protected function configure ()
    {
        $this->setName('setup:phantomjs')->setDescription('Install the phantomJS binary in the bin folder.');
    }

    /**
     * Operating system dependend installation of PhantomJS
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     * @return int|null|void
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        if(!$downloadPath = Installer::getURL(self::PHANTOMJS_VERSION)) {
            throw new \Exception('No valid download URI choosed. Please check your system configuration.');
        }
        $phantomArchive = substr(strrchr($downloadPath, '/'), 1);

        // Download the phantomJS binary
        if(!file_exists($phantomArchive)) {
            $output->writeln('Download the archive...');
            if(!file_put_contents($phantomArchive, file_get_contents($downloadPath))) {
                throw new \Exception('There was a problem due download the phantomJS binary. Please try again later.');
            }
            $output->writeln('Downloading the archive was successfully.');
        }

        // Unpack the phantomJS binary
        switch(Installer::getOS()) {
            case 'linux':
                shell_exec('tar xfvj ' . $phantomArchive);
                break;

            default:
                shell_exec('unzip ' . $phantomArchive);
                break;
        }

        // Get extracted folder name
        // @TODO refactoring needed
        $unusedFileExtensions = array('.zip', '.tar', '.bz2');
        $fileName = str_replace($unusedFileExtensions, '', $phantomArchive);

        // Move needed files in to the directories
        rename($fileName . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phantomjs', './bin/phantomjs');
        rename($fileName . DIRECTORY_SEPARATOR . 'examples', './examples');

        // Remove unneeded files
        shell_exec('rm -rf ' . $fileName);
        shell_exec('rm ' . $phantomArchive);
    }
}