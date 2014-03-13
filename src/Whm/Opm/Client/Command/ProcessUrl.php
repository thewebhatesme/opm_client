<?php
namespace Whm\Opm\Client\Command;

use Whm\Opm\Client\Server\Server;
use Whm\Opm\Client\Config\Config;
use Whm\Opm\Client\Browser\Phantom;
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
    $config = Config::createFromFile($input->getArgument('config'));

    $phantom = new Phantom($config->getPhantomExecutable());
    $httpArchive = $phantom->createHttpArchive($input->getArgument('url'));

    $server = new Server($config->getOpmServer(), $config->getClientId());

    // @todo add try catch block
    $server->addMessurement($input->getArgument('url'), $httpArchive);
  }
}