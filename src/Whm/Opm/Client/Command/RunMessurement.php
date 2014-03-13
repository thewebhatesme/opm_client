<?php
namespace Whm\Opm\Client\Command;

use Whm\Opm\Client\Shell\BlockingExecutorQueue;
use Whm\Opm\Client\Server\MessurementJob;
use Whm\Opm\Client\Server\Server;
use Whm\Opm\Client\Config\Config;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class RunMessurement extends Command
{

    private $configFile;

    private $server;

    private $blockingExecutorQueue;

    protected function configure ()
    {
        $this->setName('runMessurement')
            ->setDescription('Process an url and send the result (har file) to an opm server.')
            ->addArgument('config', InputArgument::REQUIRED, 'The config file');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $this->configFile = $input->getArgument('config');

        $config = Config::createFromFile($this->configFile);

        $this->server = new Server($config->getOpmServer(), $config->getClientId());

        $this->blockingExecutorQueue = new BlockingExecutorQueue($config->getMaxParallelRequests());

        $this->processJob($this->server->getMessurementJob());
    }

    private function processJob (MessurementJob $job)
    {
        $urls = $job->getUrls();
        $identifier = $job->getIdentifier();

        foreach ($urls as $url) {
            $this->blockingExecutorQueue->addCommand("php bin/client.php processUrl " . $this->configFile . " " . $url);
        }

        $this->blockingExecutorQueue->run();
    }
}