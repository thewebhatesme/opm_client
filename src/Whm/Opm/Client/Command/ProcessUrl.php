<?php
namespace Whm\Opm\Client\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class ProcessUrl extends Command
{

    protected function configure ()
    {
        $this->setName('processUrl')
            ->setDescription('Process an url and send the result (har file) to an opm server.')
            ->addArgument('config', InputArgument::REQUIRED, 'The config file')
            ->addArgument('url', InputArgument::REQUIRED, 'The url that has to be fetched');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $output->writeln("config: " . $input->getArgument('config') . " | " . "url: ".$input->getArgument('url'));
        $output->writeln("doing nothing ... yet");
    }
}
