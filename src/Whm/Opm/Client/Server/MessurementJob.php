<?php
namespace Whm\Opm\Client\Server;

class MessurementJob
{

    private $identifier;

    private $tasks = array();

    public function __construct ($identifier)
    {
        $this->identifier = $identifier;
    }

    public function addTask (Task $task)
    {
        $this->tasks[] = $task;
    }

    public function getTasks ()
    {
        return $this->tasks;
    }

    public function getIdentifier ()
    {
        return $this->identifier;
    }
}