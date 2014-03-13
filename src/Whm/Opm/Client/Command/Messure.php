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
use Whm\Opm\Client\Shell\BlockingExecutorQueue;
use Whm\Opm\Client\Server\Server;
use Whm\Opm\Client\Config\Config;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
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

    private $config;

    private $messurementContainer;

    /**
     *
     * @var string OPM Server URL
     */
    private $server;

    protected function configure ()
    {
        $this->setName('messure')
            ->setDescription('Run a specified messurement.')
            ->addArgument('identifier', InputArgument::REQUIRED, 'The task identifier.')
            ->addArgument('messureType', InputArgument::REQUIRED, 'The messurement type.')
            ->addArgument('parameters', InputArgument::REQUIRED, 'The parameters.');
    }

    /**
     * Initializes the configuration
     *
     * @param string $configFile
     */
    private function initConfig ($configFile)
    {
        $this->configFile = $configFile;
        $this->config = Config::createFromFile($configFile);
        $this->getEventDispatcher()->notify(new Event('config.create', array("config" => $this->config,"configFileName" => $configFile)));
    }

    private function initMessurementContainer ()
    {
        $this->messurementContainer = new MessurementContainer();
        $this->getEventDispatcher()->notify(new Event('messure.messurementcontainer.create', array("container" => $this->messurementContainer)));
    }

    private function initServer ()
    {
        $this->server = new Server($this->config);
        $this->getEventDispatcher()->notify(new Event('server.create', array("server" => $this->server)));
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
        $this->initMessurementContainer();
        $this->initServer();

        $identifier = $input->getArgument('identifier');
        $messureType = $input->getArgument("messureType");
        $parameters = unserialize($input->getArgument('parameters'));

        $messureObject = $this->messurementContainer->getMessurement($messureType);
        $result = $messureObject->run($identifier, $parameters);

        $this->server->addTaskMessurement($identifier, $result);
    }
}
