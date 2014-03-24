<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */
namespace Whm\Opm\Client\Command;

use Whm\Opm\Client\Server\MessurementResult;

use Buzz\Browser;
use Whm\Opm\Client\Messure\MessurementContainer;
use phmLabs\Components\Annovent\Event\Event;
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
 * @example $./bin/client messure
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
     * @var \Whm\Opm\Client\Config\Config Configuration object
     */
    private $config;

    /**
     *
     * @var \Whm\Opm\Client\Messure\MessurementContainer Object to hold data of messurement
     */
    private $messurementContainer;

    /**
     *
     * @var \Whm\Opm\Client\Server\Server
     */
    private $server;

    private $dryrun;

    /**
     * {@inheritDoc}
     */
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
     * @param string $configFile Path to config file
     * @uses \Whm\Opm\Client\Config\Config::createFromFilet to read configuration
     * @uses \phmLabs\Components\Annovent\Event\Event to fire an event
     */
    private function initConfig ($configFile)
    {
        $this->configFile = $configFile;
        $this->config = Config::createFromFile($configFile);
        $this->getEventDispatcher()->notify(new Event('config.create', array("config" => $this->config,"configFileName" => $configFile)));
    }

    /**
     * Initialize container to hold the data of the messurement
     *
     * @uses \Whm\Opm\Client\Messure\MessurementContainer
     * @uses \phmLabs\Components\Annovent\Event\Event to fire an event
     */
    private function initMessurementContainer ()
    {
        $this->messurementContainer = new MessurementContainer();
        $this->getEventDispatcher()->notify(new Event('messure.messurementcontainer.create', array('container' => $this->messurementContainer)));
    }

    /**
     * initialize server and create an event
     *
     * @uses \Whm\Opm\Client\Server\Server
     * @uses \phmLabs\Components\Annovent\Event\Event to fire an event
     */
    private function initServer ()
    {
        $browser = new Browser();
        $this->server = new Server($this->config, $browser);
        $this->getEventDispatcher()->notify(new Event('server.create', array('server' => $this->server)));
    }

    /**
     * Execute messurement task
     *
     * @example $./bin/client messure
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $this->dryrun = $input->getOption('dryrun');

        $this->initConfig($input->getOption('config'));
        $this->initMessurementContainer();
        $this->initServer();

        $identifier = $input->getArgument('identifier');
        $messureType = $input->getArgument("messureType");
        $parameters = unserialize($input->getArgument('parameters'));

        $messureObject = $this->messurementContainer->getMessurement($messureType);
        $metrics = $this->messurementContainer->getMetrics($messureType);

        $messurementResult = new MessurementResult();
        $rawData = $messureObject->run($identifier, $parameters);
        $messurementResult->setMessurementRawData($rawData);

        foreach( $metrics as $metric ) {
            $metricValue = $metric->calculateMetric($rawData);
            $messurementResult->addMetric($metric->getName(), $metricValue);
        }

        if ($this->dryrun) {
            $output->writeln("Identifier: " . $identifier);
            $output->writeln("Result: " . $rawData);
        } else {
            $this->server->addTaskMessurement($identifier, $rawData);
        }
    }
}