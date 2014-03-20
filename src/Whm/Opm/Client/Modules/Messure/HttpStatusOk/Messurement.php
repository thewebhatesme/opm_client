<?php

namespace Whm\Opm\Client\Modules\Messure\HttpStatusOk;

use Buzz\Browser;
use Whm\Opm\Client\Messure\Messurement as MessurementInterface;

class Messurement implements MessurementInterface
{
    public function getType ()
    {
        return "Opm:HttpStatusOk";
    }

    public function run ($identifier, array $parameters)
    {
        $browser = new Browser();
        $response = $browser->get($parameters["url"]);

        return $response->isSuccessful();
    }
}