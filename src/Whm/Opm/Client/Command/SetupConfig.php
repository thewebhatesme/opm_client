<?php

namespace Whm\Opm\Client\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class SetupConfig extends Command
{
    private $configFileName = "config.yml";

    protected function configure ()
    {
        $this->setName('setup:config')->setDescription('Process an url and send the result (har file) to an opm server.');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {

        if( file_exists($_SERVER["PWD"] . "/".$this->configFileName)) {
            $output->writeln("");
            $output->writeln("      <error>Config file already exists. Please (re)move it before creating a new one.</error>");
            $output->writeln("");
            die;
        }

        $output->writeln("");
        $output->writeln("   Open Performance Monitor");
        $output->writeln("   ========================");
        $output->writeln("");

        $clientId = readline("   Your client id: ");

        $phantomFound = false;
        while (! $phantomFound) {
            $phantom = readline("   Path to phantomjs executable: ");
            if(!is_file($phantom)) {
                $output->writeln("");
                $output->writeln("      <error>Phantomjs not found. Please try again. If you don't have phantomjs installed use client.phar setup:phantom.</error>");
                $output->writeln("");
            }else{
                $phantomFound = true;
            }
        }

        $server = readline("   Open Performance Monitor Server (press enter for default server www.linkstream): ");

        if ($server == "")
            $server = "http://www.linkstream.org";

        $maxConnections = readline("   Parallel Connections (press enter for default: 5): ");

        if ($maxConnections == "")
            $maxConnections = 5;

        $this->createConfigFile($server, $phantom, $maxConnections, $clientId);

        $output->writeln("");
        $output->writeln("   <info>Config (".$this->configFileName.") was created.</info>");
        $output->writeln("");
    }

    private function createConfigFile($server, $phantom, $maxConnections, $clientId)
    {
        ob_start();
        include __DIR__."/SetupConfig/config.yml";
        $config = ob_get_contents();
        ob_end_clean();

        file_put_contents($this->configFileName, $config);
    }
}