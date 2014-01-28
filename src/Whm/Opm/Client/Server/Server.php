<?php
namespace Whm\Opm\Client\Server;

class Server
{
  private $host;

  public function __construct($host)
  {
    $this->host = $host;
  }

  public function getRestApiUrl($clientId, $url)
  {
    return $this->host . "/add/" . $clientId . "/" . base64_encode($url) . "/";
  }
}