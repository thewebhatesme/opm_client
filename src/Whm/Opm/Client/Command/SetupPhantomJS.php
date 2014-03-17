<?php
/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Validator\Constraints\NotNull;
use Whm\Opm\Client\Console\ValidatingDialog;
use Whm\Opm\Client\Installer\PhantomJSInstaller;

/**
 * Class SetupPhantomJS
 *
 * Class to install the phantomjs binary to a specific folder and
 * copy the netsniff.js script to the project directory.
 *
 * @category Command
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  0.0.1
 * @since    2014-01-28
 * @author   Philipp Bräutigam <philipp.braeutigam@googlemail.com>
 */
class SetupPhantomJS extends Command
{
    /**
     * The PhantomJS Version
     * @const string
     */
    const PHANTOMJS_VERSION = '1.9.7';

    /**
     * The installation path for the binary
     * @var null
     */
    protected $installDir = null;

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
        try {
            $dialog = new ValidatingDialog($this->getHelperSet()->get('dialog'), $output);
            $this->installDir = $dialog->ask('Please enter your installation path (for example ./bin): ', new NotNull()) . PHP_EOL;
            $downloadPath = PhantomJSInstaller::getURL(self::PHANTOMJS_VERSION);

            $output->writeln('Downloading the phantomjs binary...');
            PhantomJSInstaller::downloadArchive($downloadPath);
            $output->writeln('Downloading was successfully.');

            $output->writeln('Install the phantomjs binary...');
            PhantomJSInstaller::extractArchive($downloadPath, $this->installDir);
        } catch(\Exception $e) {
            die('An error occured due installation routine' . PHP_EOL . $e->getMessage());
        }

        $output->writeln('Removing temporary install folder...');
        PhantomJSInstaller::cleanup();
        $output->writeln('Installation of phantomjs completed.');

        return true;
    }
}