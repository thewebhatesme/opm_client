<?php

namespace Whm\Opm\Client\Messure;

interface Metric
{
    public function calculateMetric($rawMessurementData);
    public function getName( );
}