<?php
namespace Whm\Opm\Client\Modules\Messure\HttpArchive\Command;

use Whm\Opm\Client\Server\Server;
use Whm\Opm\Client\Config\Config;
use Whm\Opm\Client\Browser\PhantomJS;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class ProcessUrl extends Command
{

    protected function configure ()
    {
        $this->setName('messure:httpArchive:processUrl')
            ->setDescription('Process an url and send the result (har file) to an opm server.')
            ->addArgument('clientId', InputArgument::REQUIRED, 'The client id')
            ->addArgument('host', InputArgument::REQUIRED, 'The server adress')
            ->addArgument('phantomJS', InputArgument::REQUIRED, 'The path to your PhantomJS executable')
            ->addArgument('url', InputArgument::REQUIRED, 'The url that has to be fetched');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
//         $config = Config::createFromFile($input->getArgument('config'));

        $phantom = new PhantomJS($input->getArgument('phantomJS'));
        $httpArchive = $phantom->createHttpArchive($input->getArgument('url'));

        $server = new Server($input->getArgument('host'), $input->getArgument('clientId'));

        // @todo add try catch block
        $server->addMessurement($input->getArgument('url'), $httpArchive);
    }
}