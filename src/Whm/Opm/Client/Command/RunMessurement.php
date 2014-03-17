<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Command;

use Whm\Opm\Client\Shell\BlockingExecutorQueue;
use Whm\Opm\Client\Server\MessurementJob;
use Whm\Opm\Client\Server\Server;
use Whm\Opm\Client\Config\Config;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

/**
 * ProcessUrl
 *
 * Process an url and send the result (har file) to an opm server
 *
 * @category Command
 * @package  OPMClient
 * @license    https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @example  $./bin/client runMessurement
 * @version   GIT: $Id$
 * @since       Date: 2014-03-12
 * @author    Nils Langner <nils.langner@phmlabs.com>
 */
class RunMessurement extends Command
{

    /**
     * @var string Path to config file
     */
    private $configFile;

    /**
     * @var string OPM Server URL
     */
    private $server;

    /**
     * @var type
     */
    private $blockingExecutorQueue;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('runMessurement')
                ->setDescription('Process an url and send the result (har file) to an opm server.')
                ->addArgument('config', InputArgument::REQUIRED, 'The config file');
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
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->configFile = $input->getArgument('config');

        $config = Config::createFromFile($this->configFile);

        $this->server = new Server($config->getOpmServer(), $config->getClientId());

        $this->blockingExecutorQueue = new BlockingExecutorQueue($config->getMaxParallelRequests());

        try {
            $this->processJob($this->server->getMessurementJob());
        } catch (\DomainException $e) {
            throw $e;
        }
    }

    /**
     * process the job
     *
     * @param \Whm\Opm\Client\Server\MessurementJob $job
     * @todo Use *\Whm\Opm\Client\Config* object to build the cli command
     *
     * @return void
     */
    private function processJob(MessurementJob $job)
    {
        $urls = $job->getUrls();

        foreach ($urls as $url) {
            $this->blockingExecutorQueue->addCommand("bin/client processUrl " . $this->configFile . " " . $url);
        }

        $this->blockingExecutorQueue->run();
    }

}
