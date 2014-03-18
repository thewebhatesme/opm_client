<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */
namespace Whm\Opm\Client\Command;

use Whm\Opm\Client\Messure\MessurementContainer;

use phmLabs\Components\Annovent\Event\Event;
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
use Whm\Opm\Client\Console\Command;

/**
 * ProcessUrl
 *
 * Process an url and send the result (har file) to an opm server
 *
 * @category Command
 * @package OPMClient
 * @license https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @example $./bin/client runMessurement
 * @version GIT: $Id$
 * @since Date: 2014-03-12
 * @author Nils Langner <nils.langner@phmlabs.com>
 */
class Messure extends Command
{

    /**
     *
     * @var string Path to config file
     */
    private $configFile;

    /**
     *
     * @var string OPM Server URL
     */
    private $server;

    /**
     *
     * @var \Whm\Opm\Client\Shell\BlockingExecutorQueue Queue to manage maximum count of simultaneous request
     */
    private $blockingExecutorQueue;

    /**
     *
     * @var DispatcherInterface Event dispatcher
     */
    private $dispatcher;

    /**
     * Set event dispatcher
     *
     * @param \phmLabs\Components\Annovent\DispatcherInterface $dispatcher
     *
     * @return void
     */
    public function setDispatcher (DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    protected function configure ()
    {
        $this->setName('messure')->setDescription('Run a specified messurement.');
    }

    /**
     * Initializes the configuration
     *
     * @param string $configFile
     */
    private function initConfig ($configFile)
    {
        $this->config = Config::createFromFile($configFile);
        $this->dispatcher->notify(new Event('run.config.create', array ("config" => $this->config, "configFileName" => $configFile)));
    }

    /**
     * Execute messurement task
     *
     * @example path description
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws \Whm\Opm\Client\Command\DomainException
     *
     * @return void
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $this->initConfig($input->getOption('config'));

        $this->server = new Server($this->config);

        $this->messurementContainer = new MessurementContainer();
        $this->dispatcher->notify(new Event('run.messurementcontainer.create', array ("config" => $this->config, "configFileName" => $configFile)));

        $this->blockingExecutorQueue = new BlockingExecutorQueue($this->config->getMaxParallelRequests());

        $this->processJob($this->server->getMessurementJob());
    }

    /**
     * process the job
     *
     * @param \Whm\Opm\Client\Server\MessurementJob $job
     * @todo Use *\Whm\Opm\Client\Config* object to build the cli command
     *
     * @return void
     */
    private function processJob (MessurementJob $job)
    {
        $tasks = $job->getTasks();

        foreach ($tasks as $task) {
            $command = $task->getCommand();
            $this->blockingExecutorQueue->addCommand($command);
        }

        $this->blockingExecutorQueue->run();
    }
}
