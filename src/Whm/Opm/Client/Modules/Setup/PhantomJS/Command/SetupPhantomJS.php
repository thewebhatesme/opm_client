<?php
namespace Whm\Opm\Client\Modules\Setup\PhantomJS\Command;

use Whm\Opm\Client\Modules\Setup\PhantomJS\Installer;

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Whm\Opm\Client\Console\Command;
use Symfony\Component\Validator\Constraints\NotNull;
use Whm\Opm\Client\Console\ValidatingDialog;

/**
 * Class SetupPhantomJS
 *
 * Class to install the phantomjs binary to a specific folder and
 * copy the netsniff.js script to the project directory.
 *
 * @category Command
 * @package OPMClient
 * @license https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version 0.0.1
 * @since 2014-01-28
 * @author Philipp Bräutigam <philipp.braeutigam@googlemail.com>
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
     *
     * @var null
     */
    protected $installDir = null;

    protected function configure ()
    {
        $this->setName('setup:phantomjs')
            ->setDescription('Install the phantomJS binary in the bin folder.')
            ->addOption('destination', "", InputOption::VALUE_OPTIONAL, "The directory you want phantomJS to be installed", "");
    }

    /**
     * Operating system dependend installation of PhantomJS
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     *
     * @return bool
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        try {
            $this->installDir = $input->getOption('destination');
            if ($this->installDir == "") {
                $dialog = new ValidatingDialog($this->getHelperSet()->get('dialog'), $output);
                $this->installDir = $dialog->ask('Please enter your installation path (for example ./bin): ', new NotNull()) . PHP_EOL;
            }
            $downloadPath = Installer::getURL(self::PHANTOMJS_VERSION);

            $output->writeln('Downloading the phantomjs binary...');
            Installer::downloadArchive($downloadPath);
            $output->writeln('Downloading was successfully.');

            $output->writeln('Install the phantomjs binary...');
            Installer::extractArchive($downloadPath, trim($this->installDir));
        } catch (\RuntimeException $e) {
            die('An error occured due installation routine' . PHP_EOL . $e->getMessage());
        }

        $output->writeln('Removing temporary install folder...');
        Installer::cleanup();
        $output->writeln('Installation of phantomjs completed.');

        return true;
    }
}