<?php

namespace Whm\Opm\Client\Messure;

abstract class OpmMessurement implements Messurement
{
    /**
     *
     * @Event("run.messurementcontainer.create")
     */
    public function register(MessurementContainer $container)
    {
        var_dump( "hjbjhbjhb");
        $container->addMessurement($this);
    }
}