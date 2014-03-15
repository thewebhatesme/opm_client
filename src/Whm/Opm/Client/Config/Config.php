<?php
namespace Whm\Opm\Client\Config;

use Symfony\Component\Yaml\Yaml;

class Config
{

  private $config = array();

  public function __construct(array $configArray)
  {
    $this->config = $configArray;
  }

  /**
   * @param string $filename the yaml file name.
   * @return \Whm\Opm\Client\Config\Config
   */
  public static function createFromFile($filename)
  {
    $yamlString = file_get_contents($filename);
    $yaml = new Yaml();

    return new self($yaml->parse($yamlString));
  }

  public function getPhantomExecutable()
  {
    return $this->config['phantom']['executable'];
  }

  public function getOpmServer()
  {
    return $this->config['opm-server']['host'];
  }

  public function getClientId()
  {
    return $this->config['opm-client']['clientid'];
  }

  public function getMaxParallelRequests()
  {
      return $this->config['opm-client']['max-parallel-requests'];
  }
}
