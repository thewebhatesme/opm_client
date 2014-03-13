<?php
namespace Whm\Opm\Client\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class SetupConfig extends Command
{

  protected function configure ()
  {
    $this->setName('setup:config')
      ->setDescription('Process an url and send the result (har file) to an opm server.');
  }

  protected function execute (InputInterface $input, OutputInterface $output)
  {
  }
}
