<?php

namespace Whm\Opm\Client\Modules\Messure\HttpStatusOk;

use Whm\Opm\Client\Messure\MessurementContainer;

class Listener
{

    /**
     * @Event("messure.messurementcontainer.create")
     */
    public function register (MessurementContainer $container)
    {
        $messure = new Messurement($this->config);
        $container->addMessurement($messure);
    }
}