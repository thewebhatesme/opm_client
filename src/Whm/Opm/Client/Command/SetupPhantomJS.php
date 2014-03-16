<?php
namespace Whm\Opm\Client\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class SetupPhantomJS extends Command
{

    protected function configure ()
    {
        $this->setName('setup:phantomjs')->setDescription('Install the phantomJS binary in the bin folder.');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {}
}
