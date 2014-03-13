<?php
namespace Whm\Opm\Client\Messure;

interface Messurement
{

    public function getType ();

    public function run ($indentifier, array $parameters);
}