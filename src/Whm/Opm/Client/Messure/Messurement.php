<?php
namespace Whm\Opm\Client\Messure;

use Whm\Opm\Client\Config\Config;

interface Messurement
{

    public function __construct ($identifier, Config $config, array $options);

    public function getCommand ();
}