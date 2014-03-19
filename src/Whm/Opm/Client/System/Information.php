<?php

namespace Whm\Opm\Client\System;

class Information
{

    static public function getPhpBin ()
    {
        if (defined("PHP_BINARY")) {
            return PHP_BINARY;
        } else {
            return PHP_BINDIR . "/php";
        }
    }
}