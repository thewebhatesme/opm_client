<?php

namespace Whm\Opm\Client\Messure;

class MessurementContainer
{
    private $messurements = array();
    private $metrics = array();

    public function addMessurement(Messurement $messurement, array $metrics = null)
    {
        $this->messurements[$messurement->getType()] = $messurement;
        $this->metrics[$messurement->getType()] = $metrics;
    }

    public function getMessurement($type)
    {
        if( !array_key_exists($type, $this->messurements)) {
            $message  = "Messutrement type (".$type.") not found.\n";
            $message .= "Known types are: " . implode(' ', array_keys($this->messurements));
            throw new \RuntimeException($message);
        }
        return $this->messurements[$type];
    }

    public function getMetrics($type)
    {
        if( !array_key_exists($type, $this->messurements)) {
            $message  = "Messutrement type (".$type.") not found.\n";
            $message .= "Known types are: " . implode(' ', array_keys($this->messurements));
            throw new \RuntimeException($message);
        }
        return $this->messurements[$type];
    }
}