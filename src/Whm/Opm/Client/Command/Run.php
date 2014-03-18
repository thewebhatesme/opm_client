<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Command;

use phmLabs\Components\Annovent\Event\Event;
use Whm\Opm\Client\Shell\BlockingExecutorQueue;
use Whm\Opm\Client\Server\MessurementJob;
use Whm\Opm\Client\Server\Server;
use Whm\Opm\Client\Config\Config;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use \Whm\Opm\Client\Console\Command;

/**
 * ProcessUrl
 *
 * Process an url and send the result (har file) to an opm server
 *
 * @category    Command
 * @package     OPMClient
 * @license     https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @example     $./bin/client run
 * @version     GIT: $Id$
 * @since       Date: 2014-03-12
 * @author      Nils Langner <nils.langner@phmlabs.com>
 */
class Run extends Command
{

    /**
     *
     * @var string OPM Server URL
     */
    private $server;

    /**
     * @var \Whm\Opm\Client\Shell\BlockingExecutorQueue Queue to manage maximum
     *      count of simultaneous request
     */
    private $blockingExecutorQueue;

    /**
     * @var DispatcherInterface Event dispatcher
     */
    private $dispatcher;
    private $config;
    private $configFile;

    /**
     * {@inheritDoc}
     */
    protected function configure() {
        $this->setName('run')->setDescription('Connect to server and run a messurement job.');
    }

    /**
     * Initializes the configuration
     *
     * @param   string $configFile path to config file
     * @uses    \Whm\Opm\Client\Server\Server
     * @uses    \phmLabs\Components\Annovent\Event\Event to fire an event
     */
    private function initConfig($configFile) {
        $this->configFile = $configFile;
        $this->config = Config::createFromFile($configFile);
        $this->getEventDispatcher()->notify(
                new Event('run.config.create', array("config" => $this->config, "configFileName" => $configFile)
                )
        );
    }

    /**
     * @uses    \Whm\Opm\Client\Server\Server
     */
    private function initServer() {
        $this->server = new Server($this->config);
    }

    /**
     * Execute messurement task
     *
     * @example $ bin/client.php run
     * @param   \Symfony\Component\Console\Input\InputInterface $input
     * @param   \Symfony\Component\Console\Output\OutputInterface $output
     * @uses    \Whm\Opm\Client\Shell\BlockingExecutorQueue
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->initConfig($input->getOption('config'));
        $this->initServer();

        $this->blockingExecutorQueue = new BlockingExecutorQueue(
                $this->config->getMaxParallelRequests()
        );

        $this->processJob($this->server->getMessurementJob());
    }

    /**
     * Process the job
     *
     * @param \Whm\Opm\Client\Server\MessurementJob $job
     */
    private function processJob(MessurementJob $job) {
        $commandPrefix = $_SERVER['_'] . ' ' . $_SERVER['argv'][0] . ' messure ';

        $tasks = $job->getTasks();

        foreach ($tasks as $identifier => $task) {
            $command = $commandPrefix . $identifier . ' ' . $task['type'] . ' "' . $task['parameters'] . '" --config '
                    . $this->configFile;
            $this->blockingExecutorQueue->addCommand($command);
        }

        $this->blockingExecutorQueue->run();
    }

}
