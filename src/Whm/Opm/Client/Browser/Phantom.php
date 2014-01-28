<?php
namespace Whm\Opm\Client\Browser;
use Whm\Opm\Client\Browser\Browser;

class Phantom implements Browser
{

  private $phantomExecutable;

  private $netsniffScript;

  public function __construct ($phantomPath = null)
  {
    $this->phantomExecutable = $phantomPath . "bin/phantomjs";
    $this->netsniffScript = $phantomPath . "examples/netsniff.js";
  }

  private function execute (array $parameters)
  {
    $cmd = $this->phantomExecutable . " " . implode($parameters, " ");
    return shell_exec($cmd);
  }

  public function createHttpArchive ($url)
  {
    $httpArchive = $this->execute(array(
        $this->netsniffScript,
        $url
    ));

    return $httpArchive;
  }
}