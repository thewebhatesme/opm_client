<?php
namespace Whm\Opm\Client\Server;

use Buzz\Browser;

use Whm\Opm\Client\Config\Config;

class Server
{
  private $host;
  private $clientId;

  private $browser;

  public function __construct($host, $clientId)
  {
    $this->host = $host;
    $this->clientId = $clientId;
  }

  public function setBrowser(Browser $browser)
  {
      $this->browser = $browser;
  }

  private function getBrowser( )
  {
      if(is_null( $this->browser)) {
          $this->browser = new Browser();
      }
      return $this->browser;
  }

  public function getUrls()
  {
      return $this->host . '/add/' . $this->clientId . '/';
  }

  public function addMessurement($url, $httpArchive)
  {
      $browser = $this->getBrowser();

      $restApi = $this->host . '/add/' . $this->clientId . '/' . base64_encode($url) . '/';
      $response = $browser->post($restApi, array(), gzcompress($httpArchive));

      if ($response->getStatusCode() != '200') {
         throw new \Exception("Couldn't connect to server");
      }
  }
}