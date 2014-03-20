<?php

namespace Whm\Opm\Client\Modules\Messure\HttpStatusOk\Messure;

use Buzz\Browser;

use Symfony\Component\Console\Output\BufferedOutput;

use Whm\Opm\Client\Browser\PhantomJS;

use Whm\Opm\Client\Config\Config;
use Whm\Opm\Client\Messure\Messurement;

class HttpStatusOk implements Messurement
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