<?php

namespace Whm\Opm\Client\Server;

class MessurementJob
{

    private $tasks = array ();

    public function addTask (Task $task)
    {
        $this->tasks[] = $task;
    }

    public function getTasks ()
    {
        return $this->tasks;
    }
}