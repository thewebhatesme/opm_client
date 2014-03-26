<?php

namespace Whm\Opm\Client\Modules\Messure\HttpStatus;

use Whm\Opm\Client\Modules\Messure\HttpStatus\Metrics\Count2xx;

use Whm\Opm\Client\Messure\MessurementContainer;

class Listener
{

    /**
     * @Event("messure.messurementcontainer.create")
     */
    public function register (MessurementContainer $container)
    {
        $metric2xx = new Count2xx();

        $messure = new Messurement($this->config);
        $container->addMessurement($messure, array($metric2xx));
    }
}