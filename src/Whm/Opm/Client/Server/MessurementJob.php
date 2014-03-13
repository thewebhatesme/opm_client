<?php
namespace Whm\Opm\Client\Server;

class MessurementJob
{

    private $tasks = array();

    public function addTask ($identifier, $type, array $parameters)
    {
        $this->tasks[$identifier] = array("type" => $type,"parameters" => serialize($parameters));
    }

    public function getTasks ()
    {
        return $this->tasks;
    }
}