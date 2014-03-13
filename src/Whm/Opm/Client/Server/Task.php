<?php
namespace Whm\Opm\Client\Server;

use Whm\Opm\Client\Config\Config;

class Task
{

    private $type;

    private $identifier;

    private $options;

    private $config;

    public function __construct ($identifier, $type, Config $config, array $options)
    {
        $this->config = $config;
        $this->type = $type;
        $this->options = $options;
        $this->identifier = $identifier;
    }

    public function getType ()
    {
        return $this->type;
    }

    public function getOptions ()
    {
        return $this->options;
    }

    public function getIdentifier ()
    {
        return $this->identifier;
    }

    public function getCommand( )
    {
        $messurementClass = $this->type;
        $messurementObject = new $messurementClass($this->identifier, $this->config, $this->options);

        return $messurementObject->getCommand( );
    }
}