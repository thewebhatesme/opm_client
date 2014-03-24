<?php

namespace Whm\Opm\Client\Modules\Messure\HttpStatus\Metrics;

use Whm\Opm\Client\Messure\Metric;

class Count2xx implements Metric
{
    public function calculateMetric($httpStatusCode)
    {
        return $httpStatusCode < 300;
    }

    public function getName()
    {
        return "Opm:HttpStatus:Count2xx";
    }
}