<?php
namespace Whm\Opm\Client\Server;

class MessurementJob
{

    private $identifier;

    private $urls = array();

    public function __construct ($identifier, array $urls)
    {
        $this->identifier = $identifier;
        $this->urls = $urls;
    }

    public function getUrls ()
    {
        return $this->urls;
    }

    public function getIdentifier ()
    {
        return $this->identifier;
    }
}