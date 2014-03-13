<?php
namespace Whm\Opm\Client\Modules\Client\Command;

use phmLabs\Components\Annovent\DispatcherInterface;
use phmLabs\Components\Annovent\Dispatcher;
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

    private $dispatcher;

    public function setDispatcher (DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    protected function configure ()
    {
        $this->setName('run')
            ->setDescription('Connect to server and run a messurement job.')
            ->addArgument('config', InputArgument::REQUIRED, 'The config file');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $this->configFile = $input->getArgument('config');

        $config = Config::createFromFile($this->configFile);

        $this->server = new Server($config);

        $this->blockingExecutorQueue = new BlockingExecutorQueue($config->getMaxParallelRequests());

        $this->processJob($this->server->getMessurementJob());
    }

    private function processJob (MessurementJob $job)
    {
        $tasks = $job->getTasks();

        foreach ($tasks as $task) {
            $command = $task->getCommand();
            var_dump($command);
            $this->blockingExecutorQueue->addCommand($command);
        }

        $this->blockingExecutorQueue->run();
    }
}