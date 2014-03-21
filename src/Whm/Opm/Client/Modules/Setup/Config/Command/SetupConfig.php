<?php
namespace Whm\Opm\Client\Modules\Setup\Config\Command;

use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Whm\Opm\Client\Console\Command;
use Whm\Opm\Client\Console\ValidatingDialog;

class SetupConfig extends Command
{

    /**
     * The name of the configuration file
     *
     * @var string
     */
    private $configFileName = "config.yml";

    protected function configure ()
    {
        $this->setName('setup:config')->setDescription('Wizard for creating a config file.');
    }

    /**
     * Checks if a client configuration file exists
     *
     * @param OutputInterface $output
     */
    private function checkIfConfigExists (OutputInterface $output)
    {
        if (file_exists($_SERVER["PWD"] . "/" . $this->configFileName)) {
            $output->writeln("\n<error> Config file already exists. Please (re)move it before creating a new one.</error>\n");
            die();
        }
    }

    /**
     * Execute the setup command to create the client configuration depending on
     * the given config values.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $this->checkIfConfigExists($output);

        $dialog = new ValidatingDialog($this->getHelperSet()->get('dialog'), $output);

        $clientId = $dialog->ask("Please enter your client id: ", new Length(5)) . "\n";
        $phantomjs = $dialog->ask("Please enter path to your phantomjs executable: ", new File());
        $server = $dialog->ask("Please enter the server address (press enter for http://www.linkstream.org): ", new Url(), false, "http://www.linkstream.org");
        $maxConnections = $dialog->ask("Please enter the number of max. connections (press enter for default: 5): ", new Range(array("min" => 1,"max" => 10)), false, 5);

        $this->createConfigFile($server, $phantomjs, $maxConnections, $clientId);

        $output->writeln("\n<info> Config (" . $this->configFileName . ") was created.</info>\n");

        return true;
    }

    /**
     * Create a client configuration file and save it on the root directory from
     * the client
     *
     * @param $server
     * @param $phantom
     * @param $maxConnections
     * @param $clientId
     */
    private function createConfigFile ($server, $phantom, $maxConnections, $clientId)
    {
        ob_start();
        include __DIR__ . "/SetupConfig/config.yml";
        $config = ob_get_contents();
        ob_end_clean();

        // Write configuration to file and save it
        file_put_contents($this->configFileName, $config);
    }
}