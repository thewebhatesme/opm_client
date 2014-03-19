<?php
namespace Whm\Opm\Client\Shell\ExecutorQueue;

class DebugExecutorQueue
{

    private $output = "";

    public function addCommand ($command)
    {
        $this->queuedCommands[] = $command;
    }

    public function run ()
    {
        foreach ($this->queuedCommands as $command) {
            $this->output .= "Executing Command: " . $command . "\n";
        }
    }

    public function getOutput ()
    {
        return $this->output;
    }
}