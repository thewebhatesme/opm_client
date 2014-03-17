<?php
namespace Whm\Opm\Client\Shell;

class BlockingExecutorQueue
{

    private $runningCommands = array();

    private $maxRunningCommands;

    private $queuedCommands = array();

    public function __construct ($maxRunningCommands = null)
    {
        $this->maxRunningCommands = $maxRunningCommands;
    }

    public function addCommand ($command)
    {
        $this->queuedCommands[] = $command;
    }

    public function run ()
    {
        foreach ($this->queuedCommands as $command) {
            while ($this->maxRunningCommandsReached()) {
                sleep(1);
            }
            $this->execute($command);
        }
    }

    private function execute ($command)
    {
        $noHubCommand = "nohup $command > /dev/null";
        $PID = shell_exec($noHubCommand);
        $this->runningCommands[$PID] = $command;
    }

    private function maxRunningCommandsReached ()
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
