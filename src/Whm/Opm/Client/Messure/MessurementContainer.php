<?php

namespace Whm\Opm\Client\Messure;

class MessurementContainer
{
    private $messurements;

    public function addMessurement(Messurement $messurement)
    {
        $this->messurements[$messurement->getType()] = $messurement;
    }

    public function getMessurement($type)
    {
        return $this->messurements[$type];
    }
}