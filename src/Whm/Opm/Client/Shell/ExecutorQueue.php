<?php
namespace Whm\Opm\Client\Shell;

class BlockingExecutorQueue
{

    private $runningCommands = array();

    private $maxRunningCommands;

    public function __construct ($maxRunningCommands = null)
    {
        $this->maxRunningCommands = $maxRunningCommands;
    }

    public function addCommand($command)
    {

    }

    public function run( )
    {

    }

    public function execute ($command)
    {
        if ($this->maxRunningCommandsReached()) {
            throw new \Exception("Unable to execute command. Numer of maximal runnign commands reached.");
        }

        $noHubCommand = "nohup $command > /dev/null";

        $PID = shell_exec($noHubCommand);
        $this->runningCommands = array(
                $PID => $command
        );
    }

    public function maxRunningCommandsReached ()
    {
        if (is_null($this->maxRunningCommands)) {
            return true;
        } else {
            return ($this->getRunningCount() >= $this->maxRunningCommands);
        }
    }


    private function getRunningCount ()
    {
        $count = 0;
        foreach ($this->runningCommands as $pid => $command) {
            if ($this->is_running($pid)) {
                $count ++;
            } else {
                unset($this->runningCommands[$pid]);
            }
        }
        return $count;
    }

    private function is_running ($PID)
    {
        exec("ps $PID", $ProcessState);
        return (count($ProcessState) >= 2);
    }
}