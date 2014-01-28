<?php
namespace Whm\Opm\Client\Config;

use Symfony\Component\Yaml\Yaml;

class Config
{

  private $config = array();

  public function __construct (array $configArray)
  {
    $this->config = $configArray;
  }

  static public function createFromFile( $filename )
  {
    $yamlString = file_get_contents($filename);
    $yaml = new Yaml();
    return new self($yaml->parse($yamlString));
  }

  public function getPhantomExecutable ()
  {
    return $this->config['phantom']['executable'];
  }

  public function getOpmServer( )
  {
    return $this->config['opm-server']['host'];
  }

  public function getClientId( )
  {
    return $this->config['opm-client']['clientid'];
  }
}