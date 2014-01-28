<?php
namespace Whm\Opm\Client\Command;
use Symfony\Component\Yaml\Yaml;
use Whm\Opm\Client\Config\Config;
use Buzz\Browser;
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
    $this->setName('subtask:processUrl')
      ->setDescription('Process an url and send the result (har file) to an opm server.')
      ->addArgument('config', InputArgument::REQUIRED, 'The config file')
      ->addArgument('url', InputArgument::REQUIRED, 'The url that has to be fetched');
  }

  protected function execute (InputInterface $input, OutputInterface $output)
  {
    $config = Config::createFromFile($input->getArgument('config'));

    $phantom = new Phantom($config->getPhantomExecutable());
    $httpArchive = $phantom->createHttpArchive($input->getArgument('url'));

    $buzz = new Browser();
    $response = $buzz->post($config->getOpmServer() . "/add/" . $config->getClientId() . "/" . base64_encode($input->getArgument('url')) . "/", array(), gzcompress($httpArchive));

    if ($response->getStatusCode() != "200") {
      $output->writeln("An error occured when trying to send the har file to the server.");
    } else {
      $output->writeln("Har file successfully send.");
    }
  }
}