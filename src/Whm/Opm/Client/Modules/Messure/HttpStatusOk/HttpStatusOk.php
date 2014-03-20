<?php

namespace Whm\Opm\Client\Modules\Messure\HttpStatusOk;

use Whm\Opm\Client\Messure\MessurementContainer;
use Whm\Opm\Client\Command\Messure;

class HttpStatusOk
{

    /**
     * @Event("messure.messurementcontainer.create")
     */
    public function register (MessurementContainer $container)
    {
        $messure = new \Whm\Opm\Client\Modules\Messure\HttpStatusOk\Messure\HttpStatusOk($this->config);
        $container->addMessurement($messure);
    }
}