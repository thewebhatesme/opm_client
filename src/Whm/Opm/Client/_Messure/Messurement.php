<?php
namespace Whm\Opm\Client\Messure;

use Whm\Opm\Client\Config\Config;

interface Messurement
{
    public function getType();
    public function run ();
}