<?php

namespace Whm\Opm\Client\Server;

class MessurementResult
{

    private $rawData = "";
    private $metrics = array();

    public function setMessurementRawData ($rawData)
    {
        $this->rawData = $rawData;
    }

    public function addMetric( $type, $result)
    {
        $this->metrics[$type] = $result;
    }

    public function getMessurementRawData()
    {
        return $this->rawData;
    }
}